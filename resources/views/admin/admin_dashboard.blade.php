@extends('layout.admin_layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="pt-4">
                <!-- Dashboard Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Sales</h5>
                                <h3 class="card-text">RM {{ number_format($totalSales, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <h3 class="card-text">{{ $totalOrders }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Product Variants</h5>
                                <h3 class="card-text">{{ $totalVariants }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales and Product Statistics -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Monthly Sales Statistics</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Top Products by Variants</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="productChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Orders -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Latest Orders</h5>
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Total (RM)</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($latestOrders as $order)
                                            <tr>
                                                <td>{{ $order->orderID }}</td>
                                                <td>{{ $order->cart->user->user_name }}</td>
                                                <td>{{ number_format($order->cart->total_amount, 2) }}</td>
                                                <td>
                                                    @if($order->tracking)
                                                        @switch($order->tracking->order_status)
                                                            @case('pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                                @break
                                                            @case('completed')
                                                                <span class="badge bg-success">Completed</span>
                                                                @break
                                                            @case('canceled')
                                                                <span class="badge bg-danger">Canceled</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary">{{ $order->tracking->order_status }}</span>
                                                        @endswitch
                                                    @else
                                                        <span class="badge bg-secondary">No Status</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No orders found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesChartData['labels']) !!},
            datasets: [{
                label: 'Monthly Sales (RM)',
                data: {!! json_encode($salesChartData['data']) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'RM ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Product Chart
    const productCtx = document.getElementById('productChart').getContext('2d');
    new Chart(productCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productChartData['labels']) !!},
            datasets: [{
                label: 'Number of Variants',
                data: {!! json_encode($productChartData['data']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
