<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartRecord;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Tracking;
use App\Models\ProductSizing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Add items to cart
     */
    public function add(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variant,product_variantID',
            'size_id' => 'required|exists:product_sizing,product_sizingID',
            'quantity' => 'required|integer|min:1'
        ]);
    
        try {
            DB::beginTransaction();
            
            // Get current active cart (with null cart_status) or create new
            $userID = Auth::id();
            $cart = Cart::firstOrCreate(
                ['userID' => $userID, 'cart_status' => null],
                ['total_amount' => 0]
            );
            
            // Check stock availability
            $productSizing = ProductSizing::findOrFail($request->size_id);
            if ($productSizing->product_stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available for selected size'
                ], 400);
            }
            
            // Create or update cart record
            CartRecord::updateOrCreate(
                [
                    'cartID' => $cart->cartID,
                    'product_sizingID' => $request->size_id
                ],
                [
                    'quantity' => DB::raw('quantity + ' . $request->quantity)
                ]
            );
            
            // Update cart total
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cart_count' => $cart->cartRecords()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * View cart contents
     */
    public function view()
    {
        $cart = Cart::where('userID', auth()->id())
                ->whereNull('cart_status')
                ->first();
    
        if ($cart) {
            $cart->load(['cartRecords.productSizing.productVariant.product', 
                         'cartRecords.productSizing.productVariant.color', 
                         'cartRecords.productSizing.productVariant.variantImages']);
        }
    
        return view('customer.cart.view', compact('cart'));
    }
    
    /**
     * Update cart quantities
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,cartID',
            'cart_records' => 'required|array',
            'cart_records.*.id' => 'required|exists:cart_records,cart_recordID',
            'cart_records.*.quantity' => 'required|integer|min:0|max:100'
        ]);
    
        DB::beginTransaction();
        try {
            $cartId = $request->input('cart_id');

            foreach ($request->cart_records as $recordData) {
                $cartRecord = CartRecord::findOrFail($recordData['id']);
                $quantity = $recordData['quantity'];
    
                if ($quantity == 0) {
                    $cartRecord->delete();
                } else {
                    $availableStock = $cartRecord->productSizing->product_stock;
                    if ($quantity > $availableStock) {
                        throw new \Exception('Quantity exceeds available stock');
                    }
                    $cartRecord->update(['quantity' => $quantity]);
                }
            }

            // Recalculate and update cart total amount
            $cart = Cart::with('cartRecords.productSizing.productVariant.product')->findOrFail($cartId);
            $newTotalAmount = 0;
            foreach ($cart->cartRecords as $record) {
                // Use actual_price from the related Product model
                $newTotalAmount += $record->quantity * $record->productSizing->productVariant->product->actual_price;
            }
            $cart->update(['total_amount' => $newTotalAmount]);

            DB::commit();
            // Change the return statement to redirect back to the cart view
            return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // You might want to redirect back with an error message as well
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove($recordId)
    {
        try {
            DB::beginTransaction();
            
            $cartRecord = CartRecord::findOrFail($recordId);
            $cart = $cartRecord->cart;
            
            if ($cart->userID != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }
            
            $cartRecord->delete();
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Item removed from cart successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to remove item from cart: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Checkout process
     */
    public function checkout()
    {
        try {
            DB::beginTransaction();
            
            // Get current cart
            $cart = $this->getCurrentCart();
            
            // Check if cart has items
            if ($cart->cartRecords->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty.');
            }
            
            // Create order
            $order = Order::create([
                'userID' => Auth::id(),
                'cartID' => $cart->cartID,
                'order_date' => now()
            ]);
            
            // Create payment record with pending status
            $payment = Payment::create([
                'orderID' => $order->orderID,
                'payment_date' => now(),
                'payment_status' => 'pending'
            ]);
            
            // Create tracking record with pending status
            $tracking = Tracking::create([
                'orderID' => $order->orderID,
                'order_status' => 'pending',
                'timestamp' => now()
            ]);
            
            // Mark cart as inactive (ordered)
            $cart->update(['status' => 'ordered']);
            
            DB::commit();
            
            return redirect()->route('order.view', $order->orderID)->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to checkout: ' . $e->getMessage());
        }
    }
    
    /**
     * Get current active cart or create a new one
     */
    private function getCurrentCart()
    {
        // First, check if user has a cart with status not equal to complete
        $existingCart = Cart::where('userID', Auth::id())
            ->where('status', '!=', 'complete')
            ->latest()
            ->first();
        
        if ($existingCart) {
            // Check if this cart is associated with an order
            $order = Order::where('cartID', $existingCart->cartID)->first();
            
            if (!$order) {
                // No order exists for this cart, so we can use it
                return $existingCart;
            } else {
                // Order exists, check tracking status
                $tracking = Tracking::where('orderID', $order->orderID)->latest()->first();
                
                if ($tracking && $tracking->order_status != 'complete') {
                    // Order status is not complete, so we can use this cart
                    return $existingCart;
                }
            }
        }
        
        // If we reach here, we need to create a new cart
        return Cart::create([
            'userID' => Auth::id(),
            'total_amount' => 0,
            'status' => 'active'
        ]);
    }
    
    /**
     * Update cart total amount
     */
    private function updateCartTotal(Cart $cart)
    {
        $total = 0;
        
        foreach ($cart->cartRecords as $record) {
            $total += $record->productVariant->product->actual_price * $record->quantity;
        }
        
        $cart->update(['total_amount' => $total]);
    }
}