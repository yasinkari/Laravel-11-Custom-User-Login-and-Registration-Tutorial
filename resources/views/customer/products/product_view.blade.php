@extends('layout.layout')

@section('css')
<style>
    .product-details {
        padding: 60px 0;
        background-color: #f9f9f9;
    }

    .product-image {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-title {
        font-size: 32px;
        font-weight: 600;
        color: #222;
        margin-bottom: 15px;
    }

    .product-price {
        font-size: 24px;
        font-weight: 700;
        color: #000;
        margin-bottom: 20px;
    }

    .product-description {
        font-size: 16px;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .variant-section {
        margin-top: 30px;
    }

    .variant-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .variant-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .variant-option {
        padding: 8px 20px;
        border: 2px solid #ddd;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .variant-option:hover,
    .variant-option.active {
        border-color: #000;
        background-color: #000;
        color: #fff;
    }

    .stock-status {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .in-stock {
        background-color: #4CAF50;
        color: white;
    }

    .out-of-stock {
        background-color: #999;
        color: white;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .quantity-selector input {
        width: 60px;
        text-align: center;
        margin: 0 10px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-add-to-cart {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        width: 100%;
        margin-bottom: 15px;
    }

    .btn-add-to-cart:hover {
        background-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .variant-details {
        margin-top: 30px;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .variant-details table {
        width: 100%;
    }

    .variant-details th,
    .variant-details td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    .variant-details th {
        font-weight: 600;
        color: #222;
    }
</style>
@endsection

@section('content')
<div class="product-details">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image">
                    <img src="{{ $product->variants->isNotEmpty() && $product->variants->first()->product_image 
                        ? asset('storage/' . $product->variants->first()->product_image) 
                        : asset('image/IMG_7282.jpg') }}" 
                        alt="{{ $product->product_name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->product_name }}</h1>
                    <div class="stock-status {{ $product->variants->where('product_stock', '>', 0)->count() > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->variants->where('product_stock', '>', 0)->count() > 0 ? 'In Stock' : 'Out of Stock' }}
                    </div>
                    <p class="product-price">RM {{ number_format($product->product_price, 2) }}</p>
                    <p class="product-description">{{ $product->product_description }}</p>

                    @if($product->variants->isNotEmpty())
                        <div class="variant-section">
                            <h3 class="variant-title">Available Variants</h3>
                            <div class="variant-details">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Tone</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product->variants as $variant)
                                            <tr>
                                                <td>{{ $variant->product_size }}</td>
                                                <td>{{ $variant->color->color_name }}</td>
                                                <td>{{ $variant->tone->tone_name }}</td>
                                                <td>{{ $variant->product_stock }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">Select Size:</label>
                                <select class="form-select mb-3">
                                    @foreach($product->variants->pluck('product_size')->unique() as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>

                                <label class="form-label">Select Color:</label>
                                <select class="form-select mb-3">
                                    @foreach($product->variants->pluck('color.color_name')->unique() as $color)
                                        <option value="{{ $color }}">{{ $color }}</option>
                                    @endforeach
                                </select>

                                <label class="form-label">Select Tone:</label>
                                <select class="form-select mb-3">
                                    @foreach($product->variants->pluck('tone.tone_name')->unique() as $tone)
                                        <option value="{{ $tone }}">{{ $tone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="quantity-selector mt-4">
                                <label>Quantity:</label>
                                <input type="number" min="1" value="1" class="form-control">
                            </div>

                            <button class="btn-add-to-cart">Add to Cart</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add your JavaScript functionality here
});
</script>
@endpush