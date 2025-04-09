@extends('layout.admin_layout')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Order Management</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->orderID }}</td>
                            <td>{{ $order->cart->user->user_name }}</td>
                            <td>RM {{ number_format($order->cart->total_amount, 2) }}</td>
                            <td>{{ $order->order_date->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($order->tracking)
                                    <span class="badge bg-{{ $order->tracking->order_status === 'completed' ? 'success' : ($order->tracking->order_status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->tracking->order_status) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No Status</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->orderID) }}" class="btn btn-sm btn-info">View</a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        Update Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('orders.updateStatus', $order->orderID) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item">Pending</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('orders.updateStatus', $order->orderID) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item">Complete</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('orders.updateStatus', $order->orderID) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit" class="dropdown-item">Cancel</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $orders->links() }}
            </div>
        </main>
    </div>
</div>
@endsection