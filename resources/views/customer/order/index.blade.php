@extends('layout.layout')

@section('css')
<style>
    .order-tabs {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        padding: 0.5rem;
    }
    
    .order-tab-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 0.5rem;
    }
    
    .order-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 1rem;
        font-weight: 500;
        text-align: center;
        border-radius: 6px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .order-tabs .nav-link i {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    
    .order-tabs .nav-link.active {
        color: #fff;
        background: #ff4d4d;
        transform: translateY(-2px);
    }
    
    .order-tabs .nav-link:not(.active):hover {
        background: #f8f9fa;
        color: #ff4d4d;
    }
    
    .order-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .order-header {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .order-body {
        padding: 1.5rem;
    }
    
    .order-product {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 1.5rem;
        align-items: center;
        padding: 1rem 0;
    }
    .empty-state {
        min-height: 400px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .empty-state-icon {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 50%;
    }
    
    .empty-state .btn-primary {
        background: linear-gradient(45deg, #ff4d4d, #ff6b6b);
        border: none;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .empty-state .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 77, 77, 0.2);
    }
    .order-product:not(:last-child) {
        border-bottom: 1px solid #eee;
    }
    
    .order-product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .order-status {
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .payment-button {
        background: linear-gradient(45deg, #ff4d4d, #ff6b6b);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .payment-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 77, 77, 0.2);
    }
    
    .btn-link {
        text-decoration: none;
        transition: transform 0.2s;
    }
    
    .btn-link:not(.collapsed) i {
        transform: rotate(180deg);
    }
    
    .btn-link i {
        font-size: 1.25rem;
        transition: transform 0.2s;
    }
    /* Add these to your existing CSS */
    .tracking-number {
        font-size: 0.9rem;
    }

    .tracking-copy code {
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-family: monospace;
    }

    .tracking-copy .btn {
        padding: 0.25rem 0.5rem;
        line-height: 1;
    }

    .tracking-copy .btn:hover {
        background-color: #e9ecef;
    }
    .order-status-to-pay { background: #ffebee; color: #ef5350; }
    .order-status-to-ship { background: #e3f2fd; color: #42a5f5; }
    .order-status-to-receive { background: #e8f5e9; color: #66bb6a; }
    .order-status-completed { background: #f3e5f5; color: #ab47bc; }
    .order-status-cancelled { background: #fafafa; color: #9e9e9e; }
    .order-status-refund { background: #fff3e0; color: #ffa726; }
</style>
@endsection

@section('content')
<div class="container py-4">
    <nav class="order-tabs">
        <ul class="nav order-tab-grid">
            <li class="nav-item">
                <a class="nav-link {{ $currentTab === 'all' ? 'active' : '' }}" href="{{ route('orders.index', ['tab' => 'all']) }}">
                    <i class="bi bi-grid-3x3"></i>
                    <span>All Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentTab === 'to-pay' ? 'active' : '' }}" href="{{ route('orders.index', ['tab' => 'to-pay']) }}">
                    <i class="bi bi-credit-card"></i>
                    <span>To Pay</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentTab === 'to-ship' ? 'active' : '' }}" href="{{ route('orders.index', ['tab' => 'to-ship']) }}">
                    <i class="bi bi-box-seam"></i>
                    <span>To Ship</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentTab === 'to-receive' ? 'active' : '' }}" href="{{ route('orders.index', ['tab' => 'to-receive']) }}">
                    <i class="bi bi-truck"></i>
                    <span>To Receive</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentTab === 'completed' ? 'active' : '' }}" href="{{ route('orders.index', ['tab' => 'completed']) }}">
                    <i class="bi bi-check-circle"></i>
                    <span>Completed</span>
                </a>
            </li>
        </ul>
    </nav>

    @if($orders->isEmpty())
    <div class="empty-state d-flex flex-column align-items-center justify-content-center py-5">
        <div class="empty-state-icon mb-4">
            <i class="bi bi-bag-x" style="font-size: 4rem; color: #ddd;"></i>
        </div>
        <h4 class="text-muted mb-2">No Orders Found</h4>
        <p class="text-muted mb-4">Looks like you haven't placed any orders yet</p>
        
    </div>
    @else
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <span class="text-muted">Order #{{ $order->orderID }}</span>
                    <span class="mx-2">·</span>
                    <span class="order-status order-status-{{ $order->order_status }}">
                        <i class="bi bi-circle-fill"></i>
                        {{ ucfirst($order->order_status) }}
                    </span>
                    @if($order->order_status === 'to-receive' && $order->tracking)
                    <div class="tracking-number mt-2">
                        <span class="text-muted">Tracking Number:</span>
                        <div class="d-inline-flex align-items-center tracking-copy">
                            <code id="tracking-{{ $order->tracking->trackingID }}" class="mx-2">{{ $order->tracking->tracking_number }}</code>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyTracking('{{ $order->tracking->tracking_number }}', this)">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                @endif
                    <div class="mt-2">
                        <h6 class="mb-0">Total: RM {{ number_format($order->cart->total_amount + $order->shipping_fee + ($order->cart->payment ? $order->cart->payment->payment_gateway_fee : 0), 2) }}</h6>
                    </div>
                    
                </div>
                <div class="d-flex align-items-center gap-3">
                    @if($order->order_status === 'to-pay')
                        <button onclick="handleOrderCheckout('{{ $order->cart->cartID }}')" class="payment-button">
                            <i class="bi bi-credit-card"></i>
                            Pay Now
                        </button>
                    @endif
                    @if($order->order_status === 'to-receive')
                        <button onclick="handleOrderReceive('{{ $order->orderID }}')" class="payment-button">
                            <i class="bi bi-box-check"></i>
                            Confirm Receive
                        </button>
                    @endif
                    <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="collapse" data-bs-target="#order{{ $order->orderID }}" aria-expanded="false">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
               
            </div>
            <div class="collapse" id="order{{ $order->orderID }}">
                <div class="order-body">
                    @foreach($order->cart->cartRecords as $cartRecord)
                    <div class="order-product">
                        <img src="{{ asset("storage/".$cartRecord->productSizing->productVariant->variantImages->first()->product_image) }}" 
                             alt="{{ $cartRecord->productSizing->productVariant->product->product_name }}" 
                             class="order-product-image">
                        <div class="order-product-details">
                            <h5 class="mb-1">{{ $cartRecord->productSizing->productVariant->product->product_name }}</h5>
                            <p class="text-muted mb-1">
                                Variant: {{ $cartRecord->productSizing->productVariant->variant_name }}
                                <span class="mx-1">·</span>
                                Size: {{ $cartRecord->productSizing->size }}
                            </p>
                            <p class="text-muted mb-0">Quantity: {{ $cartRecord->quantity }}</p>
                            
                            <!-- Add Review Link -->
                            <div class="mt-2">
                                <a href="{{ route('reviews.byCartRecord', ['cartRecordID' => $cartRecord->cart_recordID]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-star-fill me-1"></i> View Reviews
                                </a>
                            </div>
                        </div>
                        <div class="order-product-price text-end">
                            <h6 class="mb-0">RM {{ number_format($cartRecord->productSizing->productVariant->product->product_price * $cartRecord->quantity, 2) }}</h6>
                        </div>
                    </div>
                    @endforeach
                
                    <div class="order-summary mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>RM {{ number_format($order->cart->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Shipping Fee</span>
                            <span>RM {{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        @if($order->cart->payment && $order->cart->payment->payment_gateway_fee)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Payment Gateway Fee</span>
                            <span>RM {{ number_format($order->cart->payment->payment_gateway_fee, 2) }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <h6 class="mb-0">Total</h6>
                            <h6 class="mb-0">RM {{ number_format($order->cart->total_amount + $order->shipping_fee + ($order->cart->payment ? $order->cart->payment->payment_gateway_fee : 0), 2) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
@push('scripts')
<script>
    function copyTracking(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            const originalIcon = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i>';
            setTimeout(() => {
                button.innerHTML = originalIcon;
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy text: ', err);
        });
    }
    function handleOrderCheckout(cartId) {
        $.ajax({
            url: '{{ route("cart.checkout") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                payment_gateway_fee: 1.00
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.paymentUrl;
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                console.error(JSON.stringify(response));
                alert(response.error || 'An error occurred during checkout.');
            }
        });
    }

    function handleOrderReceive(orderId) {
        if (confirm('Are you sure you want to confirm receiving this order?')) {
            $.ajax({
                url: `/orders/${orderId}/receive`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert(response.error || 'An error occurred while updating the order.');
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Add collapsed class to icon when collapse is hidden
        document.querySelectorAll('.collapse').forEach(function(collapseEl) {
            collapseEl.addEventListener('hide.bs.collapse', function() {
                this.previousElementSibling.classList.add('collapsed');
            });
            collapseEl.addEventListener('show.bs.collapse', function() {
                this.previousElementSibling.classList.remove('collapsed');
            });
        });
    });
</script>
@endpush


