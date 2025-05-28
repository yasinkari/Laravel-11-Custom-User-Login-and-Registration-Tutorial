@extends('layout.admin_layout')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Order Details #{{ $order->orderID }}</h1>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer:</strong> {{ $order->cart->user->user_name }}</p>
                            <p><strong>Order Date:</strong> {{ $order->order_date->format('d/m/Y H:i') }}</p>
                            <p><strong>Total Amount:</strong> RM {{ number_format($order->cart->total_amount, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong>
                                @if($order->tracking)
                                    <span class="badge bg-{{ $order->tracking->tracking_status === 'completed' ? 'success' : ($order->tracking->tracking_status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->tracking->tracking_status) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No Status</span>
                                @endif
                            </p>
                            @if($order->tracking && $order->tracking->tracking_number)
                                <p><strong>Tracking Number:</strong> {{ $order->tracking->tracking_number }}</p>
                            @endif
                            @if($order->payment)
                                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->payment_status) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update Tracking</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->orderID) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PATCH')
                        <div class="col-md-6">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" 
                                value="{{ $order->tracking ? $order->tracking->tracking_number : '' }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Tracking</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->cart->cartRecords as $record)
                                    <tr>
                                        <td>{{ $record->productSizing->productVariant->product->product_name }}</td>
                                        <td>{{ $record->productSizing->product_size }}</td>
                                        <td>{{ $record->productSizing->productVariant->color ? $record->productSizing->productVariant->color->color_name : 'N/A' }}</td>
                                        <td>{{ $record->quantity }}</td>
                                        <td>RM {{ number_format($record->productSizing->productVariant->product->actual_price, 2) }}</td>
                                        <td>RM {{ number_format($record->quantity * $record->productSizing->productVariant->product->actual_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>RM {{ number_format($order->cart->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection