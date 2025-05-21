@extends('layout.layout')

@section('css')
<style>
    .cart-container {
        padding: 2rem 0;
    }
    .cart-table {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .cart-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    .product-details {
        font-size: 0.9rem;
    }
    .product-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .product-variant {
        color: #6c757d;
        font-size: 0.8rem;
    }
    .quantity-control {
        display: flex;
        align-items: center;
    }
    .quantity-control input {
        width: 50px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 0.25rem;
    }
    .quantity-control button {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #6c757d;
    }
    .remove-btn {
        color: #dc3545;
        background: none;
        border: none;
        cursor: pointer;
    }
    .cart-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .checkout-btn {
        background-color: #ff7f50;
        border: none;
        padding: 0.75rem 0;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .checkout-btn:hover {
        background-color: #ff6347;
    }
    .empty-cart {
        text-align: center;
        padding: 3rem 0;
    }
    .empty-cart i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    .continue-shopping {
        color: #ff7f50;
        text-decoration: none;
        font-weight: 600;
    }
    .continue-shopping:hover {
        color: #ff6347;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container cart-container">
    <h2 class="mb-4">Your Shopping Cart</h2>
    
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
    
    @if($cart->cartRecords->isEmpty())
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('products.customer') }}" class="continue-shopping">Continue Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <div class="table-responsive cart-table">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->cartRecords as $record)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                @if($record->productVariant->product->product_image)
                                                    <img src="{{ asset('storage/' . $record->productVariant->product->product_image) }}" alt="{{ $record->productVariant->product->product_name }}" class="product-image me-3">
                                                @else
                                                    <div class="product-image me-3 bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="product-details">
                                                    <div class="product-name">{{ $record->productVariant->product->product_name }}</div>
                                                    <div class="product-variant">
                                                        Size: {{ $record->productVariant->product_size }}
                                                        @if($record->productVariant->tone)
                                                            | Tone: {{ $record->productVariant->tone->tone_name }}
                                                        @endif
                                                        @if($record->productVariant->color)
                                                            | Color: {{ $record->productVariant->color->color_name }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>RM {{ number_format($record->productVariant->product->product_price, 2) }}</td>
                                        <td>
                                            <div class="quantity-control">
                                                <button type="button" class="decrease-qty" onclick="decreaseQuantity({{ $record->cartRecordID }})">-</button>
                                                <input type="number" name="quantities[{{ $record->cartRecordID }}]" value="{{ $record->quantity }}" min="1" max="{{ $record->productVariant->product_stock }}" id="qty-{{ $record->cartRecordID }}">
                                                <button type="button" class="increase-qty" onclick="increaseQuantity({{ $record->cartRecordID }}, {{ $record->productVariant->product_stock }})">+</button>
                                            </div>
                                        </td>
                                        <td>RM {{ number_format($record->productVariant->product->product_price * $record->quantity, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $record->cartRecordID) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-btn" onclick="return confirm('Are you sure you want to remove this item?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('products.customer') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                        <button type="submit" class="btn btn-primary">Update Cart</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="mb-4">Order Summary</h4>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>RM {{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="summary-item">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold">RM {{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary checkout-btn w-100 mt-3">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function decreaseQuantity(recordId) {
        const input = document.getElementById('qty-' + recordId);
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    function increaseQuantity(recordId, maxStock) {
        const input = document.getElementById('qty-' + recordId);
        if (parseInt(input.value) < maxStock) {
            input.value = parseInt(input.value) + 1;
        } else {
            alert('Sorry, only ' + maxStock + ' items available in stock.');
        }
    }
</script>
@endpush