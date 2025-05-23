<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\Tracking;
use App\Models\ProductVariant; // Add this import
use App\Models\Cart;          // Add this import

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            if (Auth::user()->user_role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->withSuccess('You have successfully logged in as admin.');
            } else {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'You do not have admin privileges.']);
            }
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function dashboard()
    {
        // Get total sales from completed orders through cart
        $totalSales = Order::whereHas('tracking', function($query) {
            $query->where('order_status', 'completed');
        })->join('carts', 'orders.cartID', '=', 'carts.cartID')
          ->sum('carts.total_amount');
    
        // Get total orders
        $totalOrders = Order::count();
    
        // Get total product variants
        $totalVariants = ProductVariant::count();
    
        // Get latest 5 orders with related data
        $latestOrders = Order::with(['cart.user', 'tracking'])
            ->latest('order_date')
            ->take(5)
            ->get();
    
        // Prepare sales chart data (monthly sales for current year)
        $salesChartData = [
            'labels' => [],
            'data' => []
        ];
    
        $monthlySales = Order::whereHas('tracking', function($query) {
            $query->where('order_status', 'completed');
        })
        ->join('carts', 'orders.cartID', '=', 'carts.cartID')
        ->selectRaw('MONTH(orders.order_date) as month, SUM(carts.total_amount) as total')
        ->whereYear('orders.order_date', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
        foreach ($monthlySales as $sale) {
            $salesChartData['labels'][] = date('F', mktime(0, 0, 0, $sale->month, 1));
            $salesChartData['data'][] = $sale->total;
        }
    
        // Prepare product statistics chart data (top 5 products by variant count)
        $productChartData = [
            'labels' => [],
            'data' => []
        ];
    
        $productStats = Product::withCount('variants')
            ->orderByDesc('variants_count')
            ->take(5)
            ->get();
    
        foreach ($productStats as $product) {
            $productChartData['labels'][] = $product->product_name;
            $productChartData['data'][] = $product->variants_count;
        }
    
        return view('admin.admin_dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalVariants',
            'latestOrders',
            'salesChartData',
            'productChartData'
        ));
    }

    // Add these methods to your AdminController
    
    public function orders()
    {
        $orders = Order::with(['cart.user', 'tracking'])
            ->latest('order_date')
            ->paginate(10);
        
        return view('admin.orders', compact('orders'));
    }
    
    public function showOrder(Order $order)
    {
        $order->load(['cart.user', 'cart.cartRecords.productVariant.product', 'tracking', 'payment']);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateOrderStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,canceled'
        ]);
    
        $tracking = $order->tracking;
        if (!$tracking) {
            $tracking = new Tracking(['orderID' => $order->orderID]);
        }
        
        $tracking->order_status = $request->status;
        $tracking->save();
    
        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}

    

