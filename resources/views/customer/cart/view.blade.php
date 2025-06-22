@extends('layout.layout')

@section('css')
<style>
    .cart-item {
        margin-bottom: 1.5rem;
    }
    .quantity-input {
        max-width: 100px;
    }
    .cart-summary {
        margin-bottom: 1.5rem;
    }
    .updating {
        opacity: 0.6;
        pointer-events: none;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h1 class="mb-5">Your Shopping Cart</h1>
    
    @if(!$cart)
        <div class="empty-cart text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem;"></i>
            <h3 class="mt-3">Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('products.customer') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Removed the form wrapper since we'll use AJAX -->
                        @foreach($cart->cartRecords as $record)
                            <div class="row cart-item" id="cart-item-{{ $record->cart_recordID }}">
                                <div class="col-md-3">
                                    @if($record->productVariant->variantImages->isNotEmpty())
                                        <img src="{{ asset('storage/' . $record->productVariant->variantImages->first()->product_image) }}" alt="{{ $record->productVariant->product->product_name }}" class="img-fluid rounded" style="max-width: 100px; height: auto;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 100px;">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <h5 class="card-title">{{ $record->productVariant->product->product_name }}</h5>
                                    <p class="text-muted">
                                        Size: {{ $record->productSizing->product_size }}
                                        @if($record->productVariant->tone)
                                            | Tone: {{ $record->productVariant->tone->tone_name }}
                                        @endif
                                        @if($record->productVariant->color)
                                            | Color: {{ $record->productVariant->color->color_name }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decreaseQuantity({{ $record->cart_recordID }})">-</button>
                                        <input type="number" class="form-control form-control-sm text-center quantity-input" 
                                               value="{{ $record->quantity }}" 
                                               min="1"
                                               max="{{ $record->productSizing->product_stock }}"
                                               id="qty-{{ $record->cart_recordID }}"
                                               onchange="updateQuantity({{ $record->cart_recordID }}, this.value, {{ $record->productSizing->product_stock }})">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="increaseQuantity({{ $record->cart_recordID }}, {{ $record->productSizing->product_stock }})">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="fw-bold" id="price-{{ $record->cart_recordID }}">RM {{ number_format($record->productVariant->product->actual_price * $record->quantity, 2) }}</p>
                                    <button type="button" class="btn btn-danger remove-item" data-record-id="{{ $record->cart_recordID }}">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                        <!-- Removed the Update Cart button -->
                    </div>
                </div>
                <div class="text-start mb-4">
                    <a href="{{ route('products.customer') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card cart-summary" id="cart-summary">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        
                        <!-- Product Promotions -->
                        @php
                            $totalDiscount = 0;
                            $promotedProducts = [];
                        @endphp
                        
                        @foreach($cart->cartRecords as $record)
                            @php
                                $product = $record->productSizing->productVariant->product;
                                $activePromotion = $product->promotionRecords()
                                    ->whereHas('promotion', function($query) {
                                        $query->where('is_active', true)
                                              ->where('start_date', '<=', now())
                                              ->where('end_date', '>=', now());
                                    })
                                    ->first();
                                
                                if ($activePromotion) {
                                    $promotedProducts[] = [
                                        'name' => $product->product_name,
                                        'promotion' => $activePromotion->promotion->promotion_name,
                                        'original_price' => $product->product_price * $record->quantity,
                                        'discount' => $product->product_price * $record->quantity * 0.1 // Assuming 10% discount
                                    ];
                                    $totalDiscount += $product->product_price * $record->quantity * 0.1;
                                }
                            @endphp
                        @endforeach
                        
                        <!-- Show Original Subtotal -->
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span id="subtotal">RM {{ number_format($cart->total_amount, 2) }}</span>
                        </div>
                        
                        <!-- Show Applied Promotions -->
                        @if(count($promotedProducts) > 0)
                            <div class="promotions-applied mb-3">
                                <h6 class="text-success mb-2">Promotions Applied</h6>
                                @foreach($promotedProducts as $item)
                                    <div class="promotion-item small mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">{{ $item['name'] }}</span>
                                            <span class="text-success">-RM {{ number_format($item['discount'], 2) }}</span>
                                        </div>
                                        <div class="small text-muted">{{ $item['promotion'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3 text-success">
                                <span>Total Savings</span>
                                <span>-RM {{ number_format($totalDiscount, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Payment Gateway Fee</span>
                            <span>RM 1.00</span>
                        </div>
                        
                        <hr>
                        
                        <!-- Final Total with Discounts -->
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="final-total">RM {{ number_format($cart->total_amount - $totalDiscount + 1, 2) }}</strong>
                        </div>
                        
                        <button onclick="handleCheckout()" type="button" class="btn btn-primary w-100">Proceed to Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
let updateTimeout;

function decreaseQuantity(recordId) {
    const input = document.getElementById('qty-' + recordId);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateQuantity(recordId, input.value, input.max);
    }
}

function increaseQuantity(recordId, maxStock) {
    const input = document.getElementById('qty-' + recordId);
    const currentValue = parseInt(input.value);
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
        updateQuantity(recordId, input.value, maxStock);
    } else {
        alert('Sorry, only ' + maxStock + ' items available in stock.');
    }
}

function updateQuantity(recordId, quantity, maxStock) {
    // Clear any existing timeout
    clearTimeout(updateTimeout);
    
    // Validate quantity
    quantity = parseInt(quantity);
    if (quantity < 1) {
        quantity = 1;
        document.getElementById('qty-' + recordId).value = quantity;
    }
    if (quantity > maxStock) {
        quantity = maxStock;
        document.getElementById('qty-' + recordId).value = quantity;
        alert('Sorry, only ' + maxStock + ' items available in stock.');
    }
    
    // Add visual feedback
    const cartItem = document.getElementById('cart-item-' + recordId);
    cartItem.classList.add('updating');
    
    // Debounce the update to avoid too many requests
    updateTimeout = setTimeout(() => {
        $.ajax({
            url: '/cart/update-quantity',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                record_id: recordId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Update the price display
                    document.getElementById('price-' + recordId).textContent = 'RM ' + response.item_total;
                    
                    // Update cart summary
                    document.getElementById('subtotal').textContent = 'RM ' + response.cart_subtotal;
                    document.getElementById('final-total').textContent = 'RM ' + response.cart_total;
                    
                    // Update cart badge
                    updateCartBadge();
                    
                    // Show success message briefly
                    showToast('success', 'Cart updated', {duration: 1000, position: 'top'});
                } else {
                    showToast('error', response.message, {duration: 3000, position: 'top'});
                }
            },
            error: function(xhr) {
                showToast('error', 'Failed to update cart', {duration: 3000, position: 'top'});
            },
            complete: function() {
                // Remove visual feedback
                cartItem.classList.remove('updating');
            }
        });
    }, 500); // Wait 500ms after user stops typing/clicking
}

function handleCheckout() {
    $.ajax({
        url: '{{ route("cart.checkout") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            cart_id: '{{ $cart ? $cart->cartID : "" }}',
            payment_gateway_fee: 1.00,
            total_discount: {{ $totalDiscount }}
        },
        success: function(response) {
            if (response.success) {
                updateCartBadge();
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

$(document).ready(function() {
    // Remove item handler
    $('.remove-item').click(function() {
        var recordId = $(this).data('record-id');
        if (confirm('Are you sure you want to remove this item?')) {
            $.ajax({
                url: '/cart/remove/' + recordId,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        updateCartBadge();
                        showToast('success', response.message, {duration: 3000, position: 'top'});
                        setTimeout(function() { location.reload(); }, 1000);
                    } else {
                        showToast('error', response.message, {duration: 3000, position: 'top'});
                    }
                },
                error: function(xhr) {
                    showToast('error', 'An error occurred while removing the item.', {duration: 3000, position: 'top'});
                }
            });
        }
    });
});
</script>
@endpush