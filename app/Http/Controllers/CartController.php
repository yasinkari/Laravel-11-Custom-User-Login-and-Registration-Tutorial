<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartRecord;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Tracking;
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
        $request->validate([
            'product_id' => 'required|exists:products,productID',
            'variants' => 'required|array',
            'variants.*' => 'exists:product_variant,product_variantID',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();
            
            // Get current active cart or create a new one
            $cart = $this->getCurrentCart();
            
            // Process each selected variant
            foreach ($request->variants as $variantId) {
                $quantity = $request->quantities[$variantId];
                
                // Skip if quantity is 0 or not set
                if (!$quantity) continue;
                
                $variant = ProductVariant::findOrFail($variantId);
                
                // Check stock availability
                if ($variant->product_stock < $quantity) {
                    return redirect()->back()->with('error', 'Not enough stock available for ' . $variant->product->product_name . ' (' . $variant->product_size . ')');
                }
                
                // Create or update cart record
                $cartRecord = CartRecord::updateOrCreate(
                    [
                        'cartID' => $cart->cartID,
                        'product_variantID' => $variantId
                    ],
                    [
                        'quantity' => DB::raw('quantity + ' . $quantity)
                    ]
                );
            }
            
            // Update cart total
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return redirect()->route('cart.view')->with('success', 'Items added to cart successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add items to cart: ' . $e->getMessage());
        }
    }
    
    /**
     * View cart contents
     */
    public function view()
    {
        $cart = $this->getCurrentCart();
        
        // Load cart records with related data
        $cart->load(['cartRecords.productVariant.product', 'cartRecords.productVariant.tone', 'cartRecords.productVariant.color']);
        
        return view('customer.cart.view', compact('cart'));
    }
    
    /**
     * Update cart quantities
     */
    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:0'
        ]);
        
        try {
            DB::beginTransaction();
            
            $cart = $this->getCurrentCart();
            
            foreach ($request->quantities as $recordId => $quantity) {
                $cartRecord = CartRecord::findOrFail($recordId);
                
                // Ensure the record belongs to the current cart
                if ($cartRecord->cartID != $cart->cartID) {
                    continue;
                }
                
                if ($quantity == 0) {
                    // Remove item from cart
                    $cartRecord->delete();
                } else {
                    // Update quantity
                    $cartRecord->update(['quantity' => $quantity]);
                }
            }
            
            // Update cart total
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Cart updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update cart: ' . $e->getMessage());
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
            
            // Ensure the cart belongs to the current user
            if ($cart->userID != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }
            
            // Delete record
            $cartRecord->delete();
            
            // Update cart total
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Item removed from cart successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to remove item from cart: ' . $e->getMessage());
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
            $total += $record->productVariant->product->product_price * $record->quantity;
        }
        
        $cart->update(['total_amount' => $total]);
    }
}