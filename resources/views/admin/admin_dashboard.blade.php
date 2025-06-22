@extends('layout.admin_layout')

@section('title', 'Admin Dashboard - NILLforMan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-12 ms-sm-auto px-md-4" style="margin-left: 200px;">
            <!-- Dashboard Header Section with improved filter and download buttons -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <!-- Centralized Month/Year Filter with improved design -->
                    <form action="{{ route('admin.dashboard') }}" method="get" class="d-flex me-3">
                        <div class="input-group">
                            <select name="month" class="form-select form-select-sm">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" class="form-select form-select-sm">
                                @for ($i = date('Y'); $i >= date('Y')-3; $i--)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-filter me-1"></i>Apply
                            </button>
                        </div>
                    </form>
                    <div class="btn-group">
                        <button id="exportPdfBtn" class="btn btn-sm btn-success">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.reload();">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Section -->
            <div class="row g-4 mb-4">
                <!-- Total Sales Card -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted fw-normal mb-0">Total Sales</h6>
                                    <h3 class="fw-bold mt-2 mb-0">RM {{ number_format($totalSales, 2) }}</h3>
                                    <div class="mt-2">
                                        @if($salesChangePercentage > 0)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="fas fa-arrow-up me-1"></i>{{ $salesChangePercentage }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @elseif($salesChangePercentage < 0)
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="fas fa-arrow-down me-1"></i>{{ abs($salesChangePercentage) }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <i class="fas fa-minus me-1"></i>0%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="avatar-md rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-dollar-sign fa-lg text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Orders Card -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted fw-normal mb-0">Total Orders</h6>
                                    <h3 class="fw-bold mt-2 mb-0">{{ $totalOrders }}</h3>
                                    <div class="mt-2">
                                        @if($ordersChangePercentage > 0)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="fas fa-arrow-up me-1"></i>{{ $ordersChangePercentage }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @elseif($ordersChangePercentage < 0)
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="fas fa-arrow-down me-1"></i>{{ abs($ordersChangePercentage) }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <i class="fas fa-minus me-1"></i>0%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="avatar-md rounded-circle bg-success-subtle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-shopping-bag fa-lg text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Variants Card -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted fw-normal mb-0">Product Variants</h6>
                                    <h3 class="fw-bold mt-2 mb-0">{{ $totalVariants }}</h3>
                                </div>
                                <div class="avatar-md rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-tags fa-lg text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Customers Card -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted fw-normal mb-0">Active Customers</h6>
                                    <h3 class="fw-bold mt-2 mb-0">{{ $activeCustomers }}</h3>
                                    <div class="mt-2">
                                        @if($customersChangePercentage > 0)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="fas fa-arrow-up me-1"></i>{{ $customersChangePercentage }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @elseif($customersChangePercentage < 0)
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="fas fa-arrow-down me-1"></i>{{ abs($customersChangePercentage) }}%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <i class="fas fa-minus me-1"></i>0%
                                            </span>
                                            <small class="text-muted ms-1">vs previous period</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="avatar-md rounded-circle bg-info-subtle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-users fa-lg text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section (Redesigned) -->
            <div class="row g-4 mb-4">
                <!-- Sales Chart -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold"><i class="fas fa-chart-line me-2 text-primary"></i>Sales Analytics</h5>
                                    <small class="text-muted">Monthly sales data for {{ $year }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Chart -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold"><i class="fas fa-chart-pie me-2 text-success"></i>Top Products</h5>
                                    <small class="text-muted">Product variant distribution</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="productChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-semibold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Recent Orders</h5>
                                    <small class="text-muted">Latest 5 orders across the system</small>
                                </div>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                                    View All Orders
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
                                                    <span class="fw-medium">{{ $order->cart->user->user_name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="fw-semibold">RM {{ number_format($order->cart->total_amount ?? 0, 2) }}</span>
                                            </td>
                                            <td class="align-middle">
                                                @if($order->tracking)
                                                    @switch($order->payment->payment_status)
                                                        @case('pending')
                                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-clock me-1"></i>Pending
                                                            </span>
                                                            @break
                                                        @case('processing')
                                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                                                <i class="fas fa-cog me-1"></i>Processing
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
                                                                {{ ucfirst($order->tracking->tracking_status) }}
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
                                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" title="More Actions">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('admin.orders.show', $order) }}"><i class="fas fa-edit me-2"></i>Edit Status</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="window.print()"><i class="fas fa-print me-2"></i>Print Invoice</a></li>
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
                        <small class="text-muted">Cart data with payment information for {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</small>
                    </div>

                    <div>
                        <button id="exportPdfBtn2" class="btn btn-sm btn-success">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </button>
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

.avatar-md {
    width: 48px;
    height: 48px;
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
    const salesChart = new Chart(salesCtx, {
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
    const productChart = new Chart(productCtx, {
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
    
    // PDF Export functionality
    function generatePDF() {
        // Show loading indicator
        const loadingEl = document.createElement('div');
        loadingEl.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50';
        loadingEl.style.zIndex = '9999';
        loadingEl.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>';
        document.body.appendChild(loadingEl);
        
        // Get current month and year from URL params or form
        const urlParams = new URLSearchParams(window.location.search);
        const month = urlParams.get('month') || document.querySelector('select[name="month"]').value;
        const year = urlParams.get('year') || document.querySelector('select[name="year"]').value;
        
        // Fetch chart data from API
        fetch(`{{ route('admin.dashboard.chart.data') }}?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                // Initialize jsPDF
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                // Cover Page
                doc.setFontSize(28);
                doc.setTextColor(13, 110, 253); // #0d6efd
                doc.text('Dashboard Report', 105, 80, { align: 'center' });
                
                doc.setFontSize(20);
                doc.setTextColor(33, 37, 41); // #212529
                doc.text(`${data.monthName} ${data.year}`, 105, 100, { align: 'center' });
                
                doc.setFontSize(16);
                doc.text(`Generated on: ${data.currentDate}`, 105, 130, { align: 'center' });
                
                // Add new page for charts
                doc.addPage();
                
                // Sales Chart
                doc.setFontSize(18);
                doc.setTextColor(13, 110, 253); // #0d6efd
                doc.text('Sales Analytics', 14, 20);
                
                // Convert canvas to image
                const salesCanvas = document.getElementById('salesChart');
                const salesImgData = salesCanvas.toDataURL('image/png', 1.0);
                doc.addImage(salesImgData, 'PNG', 14, 30, 180, 80);
                
                // Add sales analysis
                doc.setFontSize(12);
                doc.setTextColor(33, 37, 41); // #212529
                doc.text('Analysis:', 14, 120);
                
                const salesAnalysis = data.chartAnalysis.sales;
                const salesAnalysisLines = doc.splitTextToSize(salesAnalysis, 180);
                doc.text(salesAnalysisLines, 14, 130);
                
                // Product Chart
                doc.setFontSize(18);
                doc.setTextColor(13, 110, 253); // #0d6efd
                doc.text('Top Products by Variants', 14, 160);
                
                // Convert canvas to image
                const productCanvas = document.getElementById('productChart');
                const productImgData = productCanvas.toDataURL('image/png', 1.0);
                doc.addImage(productImgData, 'PNG', 64, 170, 80, 80);
                
                // Add new page for table
                doc.addPage();
                
                // Monthly Cart Analysis Table
                doc.setFontSize(18);
                doc.setTextColor(13, 110, 253); // #0d6efd
                doc.text(`Monthly Cart Analysis - ${data.monthName} ${data.year}`, 14, 20);
                
                // Create table with autoTable plugin
                doc.autoTable({
                    startY: 30,
                    head: [['Cart ID', 'Order ID', 'Customer', 'Amount (RM)', 'Payment Status', 'Date']],
                    body: data.monthlyCarts.map(cart => [
                        cart.cartID,
                        cart.orderID,
                        cart.customer,
                        cart.amount,
                        cart.paymentStatus,
                        cart.date
                    ]),
                    headStyles: {
                        fillColor: [13, 110, 253],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold'
                    },
                    alternateRowStyles: {
                        fillColor: [240, 240, 240]
                    },
                    styles: {
                        fontSize: 10
                    }
                });
                
                // Add footer
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(10);
                    doc.setTextColor(108, 117, 125); // #6c757d
                    doc.text(`© ${new Date().getFullYear()} NILLforMan - All Rights Reserved`, 105, 290, { align: 'center' });
                }
                
                // Save the PDF
                doc.save(`dashboard-report-${data.monthName}-${data.year}.pdf`);
                
                // Remove loading indicator
                document.body.removeChild(loadingEl);
            })
            .catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try again.');
                document.body.removeChild(loadingEl);
            });
    }
    
    // Attach event listeners to PDF export buttons
    document.getElementById('exportPdfBtn').addEventListener('click', generatePDF);
    document.getElementById('exportPdfBtn2').addEventListener('click', generatePDF);
});
</script>
@endpush



