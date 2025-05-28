<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of customer orders filtered by status
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $query = Order::where('userID', Auth::id())
            ->with([
                'cart',
                'cartRecords.productSizing.productVariant.variantImages',
                'cartRecords.productSizing.productVariant.product',
                'cartRecords.productSizing.productVariant.tones',
                'cartRecords.productSizing.productVariant.color',
                'tracking'  // Add this line to eager load tracking
            ])
            ->orderBy('created_at', 'desc');

        if ($tab !== 'all') {
            $query->where('order_status', $tab);
        }

        $orders = $query->get();

        return view('customer.order.index', [
            'orders' => $orders,
            'currentTab' => $tab
        ]);
    }

    /**
     * Display the order success page.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('customer.order.status.success');
    }

    /**
     * Display the order failed page.
     *
     * @return \Illuminate\View\View
     */
    public function failed()
    {
        return view('customer.order.status.failed');
    }

    /**
     * Mark an order as received/completed
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function receive(Order $order)
    {
        if ($order->userID !== Auth::id()) {
            return response()->json([
                'error' => 'Unauthorized action'
            ], 403);
        }

        if ($order->order_status !== 'to-receive') {
            return response()->json([
                'error' => 'Invalid order status'
            ], 400);
        }

        $order->update([
            'order_status' => 'completed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order marked as received'
        ]);
    }
}