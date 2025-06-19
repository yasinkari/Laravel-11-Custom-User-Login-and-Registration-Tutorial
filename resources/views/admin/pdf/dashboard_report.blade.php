<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Dashboard Report - {{ $monthName }} {{ $year }}</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.5;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        /* Cover Page Styles */
        .cover-page {
            text-align: center;
            padding-top: 150px;
        }
        
        .logo-container {
            margin-bottom: 50px;
        }
        
        .report-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0d6efd;
        }
        
        .report-subtitle {
            font-size: 20px;
            margin-bottom: 40px;
        }
        
        .report-date {
            font-size: 16px;
            margin-top: 60px;
        }
        
        /* Chart Page Styles */
        .chart-container {
            margin-bottom: 30px;
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #0d6efd;
        }
        
        .chart-analysis {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
        }
        
        /* Table Page Styles */
        .table-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #0d6efd;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            font-size: 14px;
        }
        
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .status-success {
            color: #198754;
            font-weight: bold;
        }
        
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        
        .status-failed {
            color: #dc3545;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div class="cover-page">
        <div class="logo-container">
            <img src="{{ public_path('image/IMG_7281-removebg-preview.png') }}" alt="Logo" width="200">
        </div>
        <div class="report-title">Dashboard Report</div>
        <div class="report-subtitle">{{ $monthName }} {{ $year }}</div>
        <div class="report-date">Generated on: {{ $currentDate }}</div>
    </div>
    
    <div class="page-break"></div>
    
    <!-- Charts Page -->
    <div class="chart-container">
        <div class="chart-title">Sales Analytics</div>
        <img src="{{ $salesChartUrl }}" alt="Sales Chart" width="100%">
        <div class="chart-analysis">
            <strong>Analysis:</strong> {{ $chartAnalysis['sales'] }}
        </div>
    </div>
    
    <div class="chart-container">
        <div class="chart-title">Top Products by Variants</div>
        <div style="text-align: center;">
            <img src="{{ $productChartUrl }}" alt="Product Chart" width="70%">
        </div>
        <div class="chart-analysis">
            <strong>Analysis:</strong> {{ $chartAnalysis['products'] }}
        </div>
    </div>
    
    <div class="page-break"></div>
    
    <!-- Table Page -->
    <div class="table-title">Monthly Cart Analysis - {{ $monthName }} {{ $year }}</div>
    
    <table>
        <thead>
            <tr>
                <th>Cart ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount (RM)</th>
                <th>Payment Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monthlyCarts as $cart)
                <tr>
                    <td>{{ $cart->cartID }}</td>
                    <td>{{ $cart->orderID ?? 'N/A' }}</td>
                    <td>{{ $cart->user->user_name ?? 'N/A' }}</td>
                    <td>{{ number_format($cart->total_amount, 2) }}</td>
                    <td>
                        @if($cart->payment)
                            @switch(strtolower($cart->payment->payment_status))
                                @case('success')
                                    <span class="status-success">Success</span>
                                    @break
                                @case('pending')
                                    <span class="status-pending">Pending</span>
                                    @break
                                @case('failed')
                                    <span class="status-failed">Failed</span>
                                    @break
                                @default
                                    {{ ucfirst($cart->payment->payment_status) }}
                            @endswitch
                        @else
                            <span>No Payment</span>
                        @endif
                    </td>
                    <td>
                        @if($cart->order)
                            {{ Carbon\Carbon::parse($cart->order->order_date)->format('Y-m-d H:i') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No cart data found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        &copy; {{ date('Y') }} NILLforMan - All Rights Reserved
    </div>
</body>
</html>