@extends('layout.admin_layout')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Management</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
                <form class="d-flex align-items-center" method="GET" action="{{ route('admin.orders.index') }}">
                    <select name="status" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <div class="alert alert-info">
                    No orders found.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->orderID }}</td>
                                    <td>{{ $order->cart->user->user_name }}</td>
                                    <td>RM {{ number_format($order->cart->total_amount, 2) }}</td>
                                    <td>{{ $order->order_date->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($order->tracking)
                                            <span class="badge bg-{{ $order->tracking->tracking_status === 'completed' ? 'success' : ($order->tracking->tracking_status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($order->tracking->tracking_status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">No Status</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->orderID) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Custom Compact Pagination -->
                @if($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                    </div>
                    <div class="custom-pagination">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <span class="page-btn disabled">‹</span>
                        @else
                            <a href="{{ $orders->appends(request()->query())->previousPageUrl() }}" class="page-btn">‹</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->appends(request()->query())->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->appends(request()->query())->nextPageUrl() }}" class="page-btn">›</a>
                        @else
                            <span class="page-btn disabled">›</span>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
/* Custom Compact Pagination Styles */
.custom-pagination {
    display: flex;
    gap: 2px;
    align-items: center;
}

.page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid #e3e6f0;
    background-color: #fff;
    color: #5a5c69;
    border-radius: 4px;
    transition: all 0.15s ease;
}

.page-btn:hover:not(.disabled):not(.active) {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
    color: #3a3b45;
    text-decoration: none;
}

.page-btn.active {
    background-color: #4e73df;
    border-color: #4e73df;
    color: #fff;
    font-weight: 600;
}

.page-btn.disabled {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    color: #b7b9cc;
    cursor: not-allowed;
}

/* Remove the old pagination styles */
.pagination-wrapper .pagination {
    margin-bottom: 0;
}

.pagination-wrapper .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25;
    border: 1px solid #dee2e6;
    color: #6c757d;
    text-decoration: none;
    background-color: #fff;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.pagination-wrapper .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination-wrapper .page-link svg {
    width: 0.875rem !important;
    height: 0.875rem !important;
}

.pagination-wrapper .page-item:not(:first-child) .page-link {
    margin-left: -1px;
}

.pagination-wrapper .page-item:first-child .page-link {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.pagination-wrapper .page-item:last-child .page-link {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>

@endsection