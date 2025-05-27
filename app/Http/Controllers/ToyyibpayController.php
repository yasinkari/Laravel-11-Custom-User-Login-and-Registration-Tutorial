<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Tracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ToyyibpayController extends Controller
{
    private $userSecretKey;
    private $categoryCode;
    private $apiUrl;
    private $redirectUrl; 
    private $billReturnUrl; // Declare this property
    private $billCallbackUrl; // Declare this property
    private $billNotificationUrl; // Declare this property
    
    public function __construct()
    {
        $this->userSecretKey = config('toyyibpay.secret_key');
        $this->categoryCode = config('toyyibpay.category_code');
        $this->apiUrl = config('toyyibpay.api_url');
        $this->redirectUrl = config('toyyibpay.redirect_url');
        
        // Set the return, callback and notification URLs
        $this->billReturnUrl = url(config('toyyibpay.return_url'));
        $this->billCallbackUrl = url(config('toyyibpay.callback_url'));
        $this->billNotificationUrl = url(config('toyyibpay.notification_url'));
    }
    
    /**
     * Create a bill in ToyyibPay for payment processing
     * 
     * @param int $cartID The cart ID to process payment for
     * @return \Illuminate\Http\Response
     */
    public function createBill($cartID)
    {
        try {
            // Log controller initialization
            \Log::debug('ToyyibpayController initialized', [
                'userSecretKey' => $this->userSecretKey,
                'categoryCode' => $this->categoryCode,
                'apiUrl' => $this->apiUrl
            ]);
    
            // Find the cart with its records
            $cart = Cart::with(['cartRecords.productSizing.productVariant.product', 'user'])
                ->where('cartID', $cartID)
                ->where('userID', Auth::id())
                ->first();
            
            if (!$cart) {
                \Log::error('Cart not found', ['cartID' => $cartID, 'userID' => Auth::id()]);
                return response()->json(['error' => 'Cart not found'], 404);
            }
            
            if ($cart->cartRecords->isEmpty()) {
                \Log::error('Empty cart', ['cartID' => $cartID]);
                return response()->json(['error' => 'Cart is empty'], 400);
            }
            
            // Calculate total amount (add RM 1 extra as requested)
            $totalAmount = $cart->total_amount + 1.00;
            
            // Generate a unique bill reference
            $billReference = 'BILL-' . Str::random(8) . '-' . time();
            
            // Prepare bill description
            $billDescription = 'Payment for Order #' . $billReference;
            
            // Prepare customer information
            $customerName = $cart->user->user_name;
            $customerEmail = $cart->user->email;
            $customerPhone = $cart->user->user_phone;
            
            // Prepare the bill creation payload
            $billData = [
                'userSecretKey' => $this->userSecretKey,
                'categoryCode' => $this->categoryCode,
                'billName' => 'Payment for Order',
                'billDescription' => $billDescription,
                'billPriceSetting' => 1, // Fixed amount
                'billPayorInfo' => 1, // Bill payer info is mandatory
                'billAmount' => $totalAmount * 100, // Amount in cents
                'billReturnUrl' => $this->billReturnUrl,
                'billCallbackUrl' => $this->billCallbackUrl,
                'billExternalReferenceNo' => $billReference,
                'billTo' => $customerName,
                'billEmail' => $customerEmail,
                'billPhone' => $customerPhone,
                'billSplitPayment' => 0, // 0 = No split payment
                'billPaymentChannel' => 2, // 2 = Online banking only
                'billContentEmail' => 'Thank you for your order!',
                'billChargeToCustomer' => 1, // 1 = No
            ];
            
            \Log::debug('Prepared bill data', context: $billData);
            
            // Make API request to ToyyibPay
            $response = Http::asForm()->post($this->apiUrl . '/createBill', $billData);
            \Log::debug('API response', [
                'apiUrl' => $this->apiUrl,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
    
            if ($response->successful()) {
                $result = $response->json();
                \Log::info('Payment bill created successfully', ['result' => $result]);
                
                if (isset($result[0]['BillCode'])) {
                    $billCode = $result[0]['BillCode'];
                    
                    // Start a database transaction
                    DB::beginTransaction();
    
                    // Check if cart has an order, if not create new one
                    $order = null;
                    if ($cart->orderID) {
                        // Attempt to find the existing order using the orderID on the cart
                        $order = Order::find($cart->orderID);
                    }
    
                    // If no order was found (either cart->orderID was null or order didn't exist)
                    if (!$order) {
                        // Create a new order
                        $order = Order::create([
                            'userID' => Auth::id(),
                            // cartID is no longer on the orders table based on the migration history
                            'order_date' => now(),
                            'order_status' => 'pending'
                        ]);
    
                        // Update the cart with the newly created order's ID and status
                        $cart->update([
                            'orderID' => $order->orderID,
                            'cart_status' => 'processing'
                        ]);
                    } else {
                        // If an existing order was found, just update the cart status if needed
                        $cart->update([
                            'cart_status' => 'processing'
                        ]);
                    }
    
                    // Check if payment record exists, create or update
                    $payment = Payment::where('orderID', $order->orderID)->first();
                    if (!$payment) {
                        $payment = Payment::create([
                            'orderID' => $order->orderID,
                            'payment_date' => now(),
                            'payment_status' => 'pending',
                            'bill_reference' => $billReference,
                            'bill_amount' => $totalAmount,
                            'billcode' => $billCode,
                            'status_msg' => 'Payment Pending'
                        ]);
                    } else {
                        $payment->update([
                            'payment_date' => now(),
                            'payment_status' => 'pending',
                            'bill_reference' => $billReference,
                            'bill_amount' => $totalAmount,
                            'billcode' => $billCode,
                            'status_msg' => 'Payment Pending'
                        ]);
                    }
                    
                    // Check if tracking record exists, create or update
                    $tracking = Tracking::where('orderID', $order->orderID)->first();
                    if (!$tracking) {
                        $tracking = Tracking::create([
                            'orderID' => $order->orderID,
                            'timestamp' => now(),
                            'tracking_status' => 'pending'
                        ]);
                    } else {
                        $tracking->update([
                            'timestamp' => now(),
                            'tracking_status' => 'pending'
                        ]);
                    }
                    
                    // Commit the transaction
                    DB::commit();
                    
                    // Redirect to ToyyibPay payment page
                    $paymentUrl = $this->redirectUrl . '/' . $billCode;
                    
                    // Log the generated payment URL
                    Log::info('ToyyibPay Payment URL: ' . $paymentUrl);

                    return response()->json([
                        'success' => true,
                        'message' => 'Payment bill created successfully',
                        'billCode' => $billCode,
                        'paymentUrl' => $paymentUrl,
                        'orderID' => $order->orderID
                    ]);
                }
            }
            
            return response()->json([
                'error' => 'Failed to create payment bill',
                'details' => $response->json()
            ], 500);
            
        } catch (\Exception $e) {
            \Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
                \Log::debug('Database transaction rolled back');
            }
            
            return response()->json([
                'error' => 'Failed to process payment',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Handle payment status callback from ToyyibPay
     */
    public function paymentStatus(Request $request)
    {
        // Log all request data
        \Log::info('ToyyibPay Payment Status Request:', [
            'all_data' => $request->all(),
            'billcode' => $request->billcode,
            'status_id' => $request->status_id,
            'order_id' => $request->order_id,
            'msg' => $request->msg,
            'transaction_id' => $request->transaction_id
        ]);

        // Handle the return URL redirect from ToyyibPay
        $billCode = $request->billcode;
        $status = $request->status_id;
        $billReference = $request->order_id;
        
        // Update payment and order status
        $payment = Payment::where('bill_reference', $billReference)->first();
        if ($payment) {
            $payment->update([
                'billcode' => $billCode,
                'transaction_id' => $request->transaction_id,
                'payment_status' => $status == 1 ? 'completed' : 'failed',
                'status_msg' => $request->msg,
                'payment_date' => now()
            ]);

            // Update order status if payment is successful
            if ($status == 1) {
                $payment->order->update(['order_status' => 'paid']);
            }
        }
        
        // Redirect to appropriate page based on payment status
        if ($status == 1) { // Payment successful
            return redirect()->route('order.success')->with('success', 'Payment successful!');
        } else { // Payment failed
            return redirect()->route('order.failed')->with('error', 'Payment failed or cancelled.');
        }
    }

    public function paymentCallback(Request $request)
    {
        // Process callback data
        $billCode = $request->billcode;
        $status = $request->status_id;
        $billReference = $request->order_id;
        
        // Verify payment status with ToyyibPay API
        $response = Http::get($this->apiUrl . '/getBillTransactions', [
            'billCode' => $billCode,
            'billExternalReferenceNo' => $billReference
        ]);
        
        if ($response->successful()) {
            $transaction = $response->json();
            
            // Update payment record
            $payment = Payment::where('bill_reference', $billReference)->first();
            if ($payment) {
                $payment->update([
                    'billcode' => $billCode,
                    'transaction_id' => $request->transaction_id,
                    'payment_status' => $status == 1 ? 'completed' : 'failed',
                    'status_msg' => $request->msg,
                    'payment_date' => now()
                ]);

                // Update order status if payment is successful
                if ($status == 1) {
                    $payment->order->update(['order_status' => 'paid']);
                }
            }
            
            return response()->json(['status' => 'success']);
        }
        
        return response()->json(['status' => 'error']);
    }
}