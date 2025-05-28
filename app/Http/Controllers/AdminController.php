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
        })
        ->join('carts', 'carts.orderID', '=', 'orders.orderID') // Corrected join condition
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
        ->join('carts', 'carts.orderID', '=', 'orders.orderID') // Corrected join condition
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
        $query = Order::with(['cart.user', 'tracking']);
        
        if (request('status')) {
            $query->whereHas('tracking', function($q) {
                $q->where('tracking_status', request('status'));
            });
        }
        
        $orders = $query->latest('order_date')
            ->paginate(10);
        
        return view('admin.order.index', compact('orders'));
    }
    
    public function showOrder(Order $order)
    {
        $order->load([
            'cart.user',
            'cart.cartRecords.productSizing', // Ensure productSizing is loaded
            'cart.cartRecords.productSizing.productVariant.product',
            'cart.cartRecords.productSizing.productVariant.color',
            'tracking',
            'payment'
        ]);
        return view('admin.order.show', compact('order'));
    }
    
    public function updateOrderStatus(Order $order, Request $request)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:100'
        ]);
    
        $tracking = $order->tracking;
        if (!$tracking) {
            $tracking = new Tracking(['orderID' => $order->orderID]);
        }
    
        if ($request->filled('tracking_number')) {
            $tracking->tracking_number = $request->tracking_number;
            $tracking->tracking_status = 'shipped';
            $order->order_status = 'to-receive';
        } else {
            $tracking->tracking_number = null;
            $tracking->tracking_status = 'pending';
            $order->order_status = 'pending';
        }
    
        $tracking->save();
        $order->save();
    
        return redirect()->back()->with('success', 'Order tracking updated successfully');
    }
}

    

