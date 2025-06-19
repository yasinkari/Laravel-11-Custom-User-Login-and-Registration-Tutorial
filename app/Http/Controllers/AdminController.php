<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\Tracking;
use App\Models\ProductVariant; 
use App\Models\Cart;          
use App\Models\Payment;       
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

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

    public function dashboard(Request $request)
    {
        // Get month and year from request or use current date
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        
        // Calculate previous period (for comparison)
        $previousMonth = $month == 1 ? 12 : $month - 1;
        $previousYear = $month == 1 ? $year - 1 : $year;
        
        // Get total sales from completed orders through cart for current period
        $totalSales = $this->calculateTotalSales($month, $year);
        $previousSales = $this->calculateTotalSales($previousMonth, $previousYear);
        
        // Calculate sales change percentage
        $salesChangePercentage = $previousSales > 0 ? 
            round((($totalSales - $previousSales) / $previousSales) * 100, 1) : 100;
    
        // Get total orders for current and previous periods
        $totalOrders = $this->countOrdersByPeriod($month, $year);
        $previousOrders = $this->countOrdersByPeriod($previousMonth, $previousYear);
        
        // Calculate orders change percentage
        $ordersChangePercentage = $previousOrders > 0 ? 
            round((($totalOrders - $previousOrders) / $previousOrders) * 100, 1) : 100;
    
        // Get total product variants
        $totalVariants = ProductVariant::count();
        
        // Get active customers count (users who placed orders in current period)
        $activeCustomers = $this->countActiveCustomers($month, $year);
        $previousActiveCustomers = $this->countActiveCustomers($previousMonth, $previousYear);
        
        // Calculate active customers change percentage
        $customersChangePercentage = $previousActiveCustomers > 0 ? 
            round((($activeCustomers - $previousActiveCustomers) / $previousActiveCustomers) * 100, 1) : 100;
    
        // Get latest 5 orders with related data
        $latestOrders = Order::with(['cart.user', 'tracking'])
            ->latest('order_date')
            ->take(5)
            ->get();
    
        // Prepare sales chart data (monthly sales for selected year)
        $salesChartData = $this->prepareSalesChartData($year);
    
        // Prepare product statistics chart data (top 5 products by variant count)
        $productChartData = $this->prepareProductChartData();
        
        // Get carts filtered by month and year with payment information
        $monthlyCarts = Cart::byMonthYear($month, $year)
            ->with(['order', 'payment', 'user'])
            ->get();
    
        return view('admin.admin_dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalVariants',
            'activeCustomers',
            'latestOrders',
            'salesChartData',
            'productChartData',
            'monthlyCarts',
            'month',
            'year',
            'salesChangePercentage',
            'ordersChangePercentage',
            'customersChangePercentage'
        ));
    }
    
    // Helper method to calculate total sales for a specific period
    private function calculateTotalSales($month, $year)
    {
        return Order::whereHas('tracking', function($query) {
                $query->where('order_status', 'completed');
            })
            ->join('carts', 'carts.orderID', '=', 'orders.orderID')
            ->whereMonth('orders.order_date', $month)
            ->whereYear('orders.order_date', $year)
            ->sum('carts.total_amount');
    }
    
    // Helper method to count orders for a specific period
    private function countOrdersByPeriod($month, $year)
    {
        return Order::whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->count();
    }
    
    // Helper method to count active customers for a specific period
    private function countActiveCustomers($month, $year)
    {
        return Order::whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->distinct('userID')
            ->count('userID');
    }
    
    // Helper method to prepare sales chart data
    private function prepareSalesChartData($year)
    {
        $salesChartData = [
            'labels' => [],
            'data' => []
        ];
    
        $monthlySales = Order::whereHas('tracking', function($query) {
                $query->where('order_status', 'completed');
            })
            ->join('carts', 'carts.orderID', '=', 'orders.orderID') 
            ->selectRaw('MONTH(orders.order_date) as month, SUM(carts.total_amount) as total')
            ->whereYear('orders.order_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        // Initialize all months with zero values
        $allMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonths[$i] = 0;
        }
        
        // Fill in actual values
        foreach ($monthlySales as $sale) {
            $allMonths[$sale->month] = $sale->total;
        }
        
        // Create final chart data
        foreach ($allMonths as $month => $total) {
            $salesChartData['labels'][] = date('F', mktime(0, 0, 0, $month, 1));
            $salesChartData['data'][] = $total;
        }
        
        return $salesChartData;
    }
    
    // Helper method to prepare product chart data
    private function prepareProductChartData()
    {
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
        
        return $productChartData;
    }
    
    // Download dashboard data as PDF
    public function downloadDashboardData(Request $request)
    {
        // Check if user has admin role
        if (!Auth::check() || Auth::user()->user_role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
        
        // Get month and year from request or use current date
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        
        // Get carts filtered by month and year with payment information
        $monthlyCarts = Cart::byMonthYear($month, $year)
            ->with(['order', 'payment', 'user'])
            ->get();
            
        // Prepare sales chart data (monthly sales for selected year)
        $salesChartData = $this->prepareSalesChartData($year);
    
        // Prepare product statistics chart data (top 5 products by variant count)
        $productChartData = $this->prepareProductChartData();
        
        // Generate chart images using QuickChart.io
        $salesChartUrl = $this->generateSalesChartImage($salesChartData);
        $productChartUrl = $this->generateProductChartImage($productChartData);
        
        // Calculate statistics for chart explanations
        $chartAnalysis = $this->generateChartAnalysis($salesChartData, $productChartData);
        
        // Format month and year for display
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $currentDate = Carbon::now()->format('Y-m-d');
        
        // IMPORTANT: Enable remote image loading for dompdf
        // Make sure this is set right before loading the view
        PDF::setOptions(['enable_remote' => true, 'isRemoteEnabled' => true]);
        
        // Load the PDF view with data
        $pdf = PDF::loadView('admin.pdf.dashboard_report', [
            'monthlyCarts' => $monthlyCarts,
            'month' => $month,
            'year' => $year,
            'monthName' => $monthName,
            'currentDate' => $currentDate,
            'salesChartUrl' => $salesChartUrl,
            'productChartUrl' => $productChartUrl,
            'chartAnalysis' => $chartAnalysis
        ]);
        
        // Set paper to A4 and use landscape orientation for better chart display
        $pdf->setPaper('a4');
        
        // Generate PDF filename
        $filename = 'dashboard-report-' . $monthName . '-' . $year . '.pdf';
        
        // Return the PDF for download
        return $pdf->stream($filename);
    }
    
    /**
     * Generate sales chart image using QuickChart.io
     */
    private function generateSalesChartImage($salesChartData)
    {
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $salesChartData['labels'],
                'datasets' => [
                    [
                        'label' => 'Monthly Sales',
                        'data' => $salesChartData['data'],
                        'fill' => false,
                        'borderColor' => 'rgb(13, 110, 253)',
                        'tension' => 0.1
                    ]
                ]
            ],
            'options' => [
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Sales Analytics ' . date('Y'),
                        'font' => [
                            'size' => 16
                        ]
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'callback' => "function(value) { return 'RM' + value.toFixed(2); }"
                        ]
                    ]
                ]
            ]
        ];
        
        // Convert chart configuration to JSON and encode for URL
        $chartConfigJson = json_encode($chartConfig);
        $encodedConfig = urlencode($chartConfigJson);
        
        // Generate chart URL
        return "https://quickchart.io/chart?width=800&height=400&c={$encodedConfig}";
    }
    
    /**
     * Generate product chart image using QuickChart.io
     */
    private function generateProductChartImage($productChartData)
    {
        $chartConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $productChartData['labels'],
                'datasets' => [
                    [
                        'data' => $productChartData['data'],
                        'backgroundColor' => [
                            '#0d6efd',
                            '#198754',
                            '#ffc107',
                            '#dc3545',
                            '#0dcaf0',
                            '#6f42c1'
                        ],
                        'borderWidth' => 0
                    ]
                ]
            ],
            'options' => [
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Top Products by Variants',
                        'font' => [
                            'size' => 16
                        ]
                    ]
                ]
            ]
        ];
        
        // Convert chart configuration to JSON and encode for URL
        $chartConfigJson = json_encode($chartConfig);
        $encodedConfig = urlencode($chartConfigJson);
        
        // Generate chart URL
        return "https://quickchart.io/chart?width=500&height=500&c={$encodedConfig}";
    }
    
    /**
     * Generate analysis text for charts
     */
    private function generateChartAnalysis($salesChartData, $productChartData)
    {
        $analysis = [];
        
        // Sales chart analysis
        $salesData = $salesChartData['data'];
        $salesLabels = $salesChartData['labels'];
        
        // Find highest and lowest months
        $maxSales = max($salesData);
        $minSales = min($salesData);
        $maxMonth = $salesLabels[array_search($maxSales, $salesData)];
        $minMonth = $salesLabels[array_search($minSales, $salesData)];
        
        // Calculate average monthly sales
        $avgSales = array_sum($salesData) / count($salesData);
        
        // Generate sales analysis text
        $analysis['sales'] = "Sales performance analysis shows that {$maxMonth} had the highest revenue at RM" . number_format($maxSales, 2) . 
                           ", while {$minMonth} recorded the lowest at RM" . number_format($minSales, 2) . 
                           ". The average monthly sales for the year is RM" . number_format($avgSales, 2) . ".";
        
        // If there's a clear trend, mention it
        $firstHalf = array_sum(array_slice($salesData, 0, 6));
        $secondHalf = array_sum(array_slice($salesData, 6, 6));
        if ($secondHalf > $firstHalf * 1.2) {
            $analysis['sales'] .= " There's a positive trend with sales improving in the second half of the year.";
        } elseif ($firstHalf > $secondHalf * 1.2) {
            $analysis['sales'] .= " Sales were stronger in the first half of the year compared to the second half.";
        }
        
        // Product chart analysis
        $productData = $productChartData['data'];
        $productLabels = $productChartData['labels'];
        
        // Find top product and calculate its percentage
        $topProductIndex = array_search(max($productData), $productData);
        $topProduct = $productLabels[$topProductIndex];
        $topProductCount = $productData[$topProductIndex];
        $totalVariants = array_sum($productData);
        $topProductPercentage = round(($topProductCount / $totalVariants) * 100);
        
        // Generate product analysis text
        $analysis['products'] = "Product analysis reveals that '{$topProduct}' is the leading product with {$topProductCount} variants, " . 
                              "representing approximately {$topProductPercentage}% of the top 5 products' variants. ";
        
        // Add recommendation based on product distribution
        if ($topProductPercentage > 50) {
            $analysis['products'] .= "Consider diversifying your product range as there's a heavy reliance on a single product.";
        } else {
            $analysis['products'] .= "The product portfolio shows a healthy distribution across multiple products.";
        }
        
        return $analysis;
    }
    
    // Create CSV content


    // Add this new method for chart data API
    public function getChartData(Request $request)
    {
        // Get month and year from request or use current date
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        
        // Prepare sales chart data
        $salesChartData = $this->prepareSalesChartData($year);
        
        // Prepare product statistics chart data
        $productChartData = $this->prepareProductChartData();
        
        // Get monthly carts data
        $monthlyCarts = Cart::byMonthYear($month, $year)
            ->with(['order', 'payment', 'user'])
            ->get()
            ->map(function($cart) {
                return [
                    'cartID' => $cart->cartID,
                    'orderID' => $cart->orderID ?? 'N/A',
                    'customer' => $cart->user->user_name ?? 'N/A',
                    'amount' => number_format($cart->total_amount, 2),
                    'paymentStatus' => $cart->payment ? $cart->payment->payment_status : 'No Payment',
                    'date' => $cart->order ? Carbon::parse($cart->order->order_date)->format('Y-m-d H:i') : 'N/A'
                ];
            });
        
        // Generate chart analysis
        $chartAnalysis = $this->generateChartAnalysis($salesChartData, $productChartData);
        
        // Return data as JSON
        return response()->json([
            'salesChartData' => $salesChartData,
            'productChartData' => $productChartData,
            'monthlyCarts' => $monthlyCarts,
            'chartAnalysis' => $chartAnalysis,
            'month' => $month,
            'year' => $year,
            'monthName' => date('F', mktime(0, 0, 0, $month, 1)),
            'currentDate' => Carbon::now()->format('Y-m-d')
        ]);
    }
    
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

    

