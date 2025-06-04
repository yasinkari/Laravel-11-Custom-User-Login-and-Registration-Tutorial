@extends('layout.admin_layout')

@section('title', 'Admin Dashboard - NILLforMan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <!-- Welcome Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2 text-primary"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</h1>
                    <p class="text-muted mb-0">Welcome back! Here's what's happening with your store today.</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Dashboard Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-gradient rounded-circle p-3 text-white">
                                        <i class="fas fa-dollar-sign fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-normal">Total Sales</h6>
                                    <h3 class="mb-0 fw-bold text-primary">RM {{ number_format($totalSales, 2) }}</h3>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> +12.5% from last month</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-gradient rounded-circle p-3 text-white">
                                        <i class="fas fa-shopping-cart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-normal">Total Orders</h6>
                                    <h3 class="mb-0 fw-bold text-success">{{ $totalOrders }}</h3>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> +8.2% from last month</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-gradient rounded-circle p-3 text-white">
                                        <i class="fas fa-box fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-normal">Product Variants</h6>
                                    <h3 class="mb-0 fw-bold text-info">{{ $totalVariants }}</h3>
                                    <small class="text-info"><i class="fas fa-minus"></i> No change</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning bg-gradient rounded-circle p-3 text-white">
                                        <i class="fas fa-users fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-normal">Active Customers</h6>
                                    <h3 class="mb-0 fw-bold text-warning">{{ $totalOrders > 0 ? $latestOrders->count() : 0 }}</h3>
                                    <small class="text-success"><i class="fas fa-arrow-up"></i> +5.1% from last month</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Charts Section -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold"><i class="fas fa-chart-line me-2 text-primary"></i>Sales Analytics</h5>
                                    <small class="text-muted">Monthly revenue trends</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-calendar me-1"></i>Last 12 months
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Last 6 months</a></li>
                                        <li><a class="dropdown-item" href="#">Last 12 months</a></li>
                                        <li><a class="dropdown-item" href="#">This year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-chart-pie me-2 text-success"></i>Top Products</h5>
                            <small class="text-muted">By variant count</small>
                        </div>
                        <div class="card-body">
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Recent Orders Table -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold"><i class="fas fa-list-alt me-2 text-info"></i>Recent Orders</h5>
                                    <small class="text-muted">Latest customer transactions</small>
                                </div>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View All Orders
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 fw-semibold">Order ID</th>
                                            <th class="border-0 fw-semibold">Customer</th>
                                            <th class="border-0 fw-semibold">Amount</th>
                                            <th class="border-0 fw-semibold">Status</th>
                                            <th class="border-0 fw-semibold">Date</th>
                                            <th class="border-0 fw-semibold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestOrders as $order)
                                        <tr>
                                            <td class="align-middle">
                                                <span class="fw-semibold text-primary">#{{ $order->orderID }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                    <span class="fw-medium">{{ $order->cart->user->user_name }}</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="fw-semibold">RM {{ number_format($order->cart->total_amount, 2) }}</span>
                                            </td>
                                            <td class="align-middle">
                                                @if($order->tracking)
                                                    @switch($order->tracking->order_status)
                                                        @case('pending')
                                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-clock me-1"></i>Pending
                                                            </span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-check me-1"></i>Completed
                                                            </span>
                                                            @break
                                                        @case('canceled')
                                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-times me-1"></i>Canceled
                                                            </span>
                                                            @break
                                                        @case('to-ship')
                                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-shipping-fast me-1"></i>To Ship
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                                                {{ ucfirst($order->tracking->order_status) }}
                                                            </span>
                                                    @endswitch
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                                        <i class="fas fa-question me-1"></i>No Status
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</span>
                                                <br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($order->order_date)->format('h:i A') }}</small>
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Quick Actions" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit Status</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print Invoice</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                    <h6>No orders found</h6>
                                                    <p class="mb-0">Orders will appear here once customers start purchasing.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- Monthly Cart Analysis Section -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-semibold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Monthly Cart Analysis</h5>
                        <small class="text-muted">Cart data with payment information</small>
                    </div>
                    <div class="d-flex">
                        <form action="{{ route('admin.dashboard') }}" method="get" class="d-flex">
                            <select name="month" class="form-select form-select-sm me-2">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" class="form-select form-select-sm me-2">
                                @for ($i = date('Y'); $i >= date('Y')-3; $i--)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-semibold">Cart ID</th>
                                <th class="border-0 fw-semibold">Order ID</th>
                                <th class="border-0 fw-semibold">Customer</th>
                                <th class="border-0 fw-semibold">Amount</th>
                                <th class="border-0 fw-semibold">Payment Status</th>
                                <th class="border-0 fw-semibold">Date</th>
                                <th class="border-0 fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyCarts as $cart)
                            <tr>
                                <td class="align-middle">
                                    <span class="fw-semibold text-primary">#{{ $cart->cartID }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="fw-semibold">#{{ $cart->orderID }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <span class="fw-medium">{{ $cart->user->user_name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="fw-semibold">RM {{ number_format($cart->total_amount, 2) }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($cart->payment)
                                        @switch($cart->payment->payment_status)
                                            @case('success')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    <i class="fas fa-check me-1"></i>Paid
                                                </span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">
                                                    <i class="fas fa-times me-1"></i>Failed
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                                    {{ ucfirst($cart->payment->payment_status) }}
                                                </span>
                                        @endswitch
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                            <i class="fas fa-question me-1"></i>No Payment
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $cart->order ? \Carbon\Carbon::parse($cart->order->order_date)->format('M d, Y') : 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $cart->order ? \Carbon\Carbon::parse($cart->order->order_date)->format('h:i A') : '' }}</small>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.orders.show', $cart->orderID) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                        <h6>No carts found for this period</h6>
                                        <p class="mb-0">Try selecting a different month or year.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Custom Styles -->
<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.avatar-sm {
    width: 32px;
    height: 32px;
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1);
}

.bg-secondary-subtle {
    background-color: rgba(108, 117, 125, 0.1);
}

.border-primary-subtle {
    border-color: rgba(13, 110, 253, 0.2) !important;
}

.border-success-subtle {
    border-color: rgba(25, 135, 84, 0.2) !important;
}

.border-warning-subtle {
    border-color: rgba(255, 193, 7, 0.2) !important;
}

.border-danger-subtle {
    border-color: rgba(220, 53, 69, 0.2) !important;
}

.border-info-subtle {
    border-color: rgba(13, 202, 240, 0.2) !important;
}

.border-secondary-subtle {
    border-color: rgba(108, 117, 125, 0.2) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.fw-semibold {
    font-weight: 600;
}

.text-primary {
    color: #0d6efd !important;
}

.text-success {
    color: #198754 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-info {
    color: #0dcaf0 !important;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesChartData['labels']) !!},
            datasets: [{
                label: 'Monthly Sales (RM)',
                data: {!! json_encode($salesChartData['data']) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#0d6efd',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'RM ' + value.toLocaleString();
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Enhanced Product Chart
    const productCtx = document.getElementById('productChart').getContext('2d');
    new Chart(productCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($productChartData['labels']) !!},
            datasets: [{
                data: {!! json_encode($productChartData['data']) !!},
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#0dcaf0',
                    '#6f42c1'
                ],
                borderWidth: 0,
                hoverBorderWidth: 2,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            cutout: '60%'
        }
    });

    // Auto-refresh functionality
    setInterval(function() {
        // Add auto-refresh logic here if needed
    }, 300000); // Refresh every 5 minutes
});
</script>
@endpush



