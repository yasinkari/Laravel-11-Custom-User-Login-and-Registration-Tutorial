@extends('layout.layout')

@section('css')
<style>
    /* Professional styling based on the reference image */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fff;
        color: #333;
    }
    
    .products-section {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        color: #0f2c1f;
    }
    
    .page-title:after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #0f2c1f, #2a5a4a);
        margin: 15px auto 0;
    }
    
    .breadcrumb-container {
        margin-bottom: 30px;
        font-size: 14px;
    }
    
    .breadcrumb-container a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .breadcrumb-container a:hover {
        color: #0f2c1f;
    }
    
    .breadcrumb-container span {
        margin: 0 8px;
        color: #999;
    }
    
    .filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .filter-dropdown {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        background-color: #fff;
    }
    
    .product-card {
        border: none;
        transition: all 0.3s;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-image {
        position: relative;
        overflow: hidden;
        border-radius: 0;
        height: 300px;
    }
    
    .product-image img {
        object-fit: cover;
        height: 100%;
        width: 100%;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    /* Refined overlay on hover */
    .product-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 44, 31, 0);
        transition: background 0.3s ease;
    }
    
    .product-card:hover .product-image::after {
        background: rgba(15, 44, 31, 0.05);
    }
    
    .product-discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #0f2c1f;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 0;
    }
    
    .product-info {
        padding: 15px 10px;
        text-align: center;
    }
    
    .product-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
        text-transform: uppercase;
        color: #0f2c1f;
    }
    
    .product-brand {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .product-price-container {
        margin-bottom: 15px;
    }
    
    .product-price {
        font-weight: 600;
        color: #0f2c1f;
        font-size: 16px;
    }
    
    .product-original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 8px;
    }
    
    /* Enhanced Add to Cart Button */
    .btn-add-to-cart {
        background-color: #0f2c1f;
        color: #fff;
        border: none;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 10px;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .btn-add-to-cart:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: all 0.5s ease;
    }
    
    .btn-add-to-cart:hover {
        background-color: #143c2a;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    
    .btn-add-to-cart:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    
    .btn-add-to-cart:hover:before {
        left: 100%;
    }
    
    .btn-add-to-cart i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }
    
    .btn-add-to-cart:hover i {
        transform: translateX(-3px);
    }
    
    .btn-view-details {
        background-color: transparent;
        color: #0f2c1f;
        border: 1px solid #0f2c1f;
        padding: 10px 15px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s;
        width: 100%;
        border-radius: 0;
        letter-spacing: 0.5px;
    }
    
    .btn-view-details:hover {
        background-color: #0f2c1f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .btn-view-details:active {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .pagination {
        margin-top: 40px;
        justify-content: center;
    }
    
    .pagination .page-item .page-link {
        color: #0f2c1f;
        border-color: #ddd;
        margin: 0 5px;
        border-radius: 0;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0f2c1f;
        border-color: #0f2c1f;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: rgba(15, 44, 31, 0.05);
    }
    
    .product-count {
        font-size: 14px;
        color: #666;
    }
    .promotion-badges .badge {
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 0;
    font-weight: 500;
    background: linear-gradient(45deg, #0f2c1f, #2a5a4a);
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="products-section">
    <div class="container">
        <div class="breadcrumb-container">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="#" class="active">Products</a>
        </div>
        
        <h1 class="page-title">BAJU MELAYU</h1>
        
        <div class="filter-row">
            <div class="product-count">
                <span>1 item</span>
            </div>
            
            {{-- <div class="d-flex">
                <select class="filter-dropdown me-3">
                    <option>Sort By</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest First</option>
                </select>
                
                <select class="filter-dropdown me-3">
                    <option>Below RM 50</option>
                    <option>RM 50 - RM 100</option>
                    <option>RM 100 - RM 150</option>
                    <option>Above RM 150</option>
                </select>
                
                <select class="filter-dropdown">
                    <option>Select Stock</option>
                    <option>In Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div> --}}
        </div>
        
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <div class="product-image">
                        @if($product->variants->isNotEmpty() && $product->variants->first()->variantImages->isNotEmpty())
                            <img src="{{ Storage::url($product->variants->first()->variantImages->first()->product_image) }}" 
                                 alt="{{ $product->product_name }}">
                        @else
                            <img src="{{ asset('image/placeholder.jpg') }}" 
                                 alt="{{ $product->product_name }}">
                        @endif
                        
                        {{-- Add Promotion Badge --}}
                        @php
                            $activePromotion = $product->promotionRecords()
                                ->whereHas('promotion', function($query) {
                                    $query->where('is_active', true)
                                          ->where('start_date', '<=', now())
                                          ->where('end_date', '>=', now());
                                })
                                ->with('promotion')
                                ->first();
                        @endphp
                        
                        @if($activePromotion)
                            <div class="product-discount-badge">
                                {{ $activePromotion->promotion->promotion_name }}
                                <small class="promotion-period">Valid until {{ $activePromotion->promotion->end_date->format('d M Y') }}</small>
                            </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h5 class="product-title">{{ $product->product_name }}</h5>
                        <div class="product-price-container">
                            @if($product->actual_price < $product->product_price)
                                <span class="product-original-price">RM{{ number_format($product->product_price, 2) }}</span>
                                <span class="product-price">RM{{ number_format($product->actual_price, 2) }}</span>
                                @if($activePromotion)
                                    <div class="promotion-info">
                                        <span class="promotion-type">{{ $activePromotion->promotion->promotion_type }}</span>
                                        
                                    </div>
                                @endif
                            @else
                                <span class="product-price">RM{{ number_format($product->product_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.view', $product) }}" class="btn btn-view-details">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection