@extends('layout.layout')

@section('css')
<style>
    /* Professional styling based on the JAKEL reference */
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
    }
    
    .page-title:after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: #000;
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
        color: #000;
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
        transition: transform 0.3s;
        margin-bottom: 30px;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-image {
        position: relative;
        overflow: hidden;
        border-radius: 4px 4px 0 0;
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
    
    /* Optional: Add a subtle overlay on hover */
    .product-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0);
        transition: background 0.3s ease;
    }
    
    .product-card:hover .product-image::after {
        background: rgba(0,0,0,0.05);
    }
    
    .product-discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #d9534f;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 2px;
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
        color: #000;
        font-size: 16px;
    }
    
    .product-original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 8px;
    }
    
    .btn-add-to-cart {
        background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%);
        color: #fff;
        border: none;
        padding: 12px 20px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    
    .btn-add-to-cart:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s ease;
    }
    
    .btn-add-to-cart:hover {
        background: linear-gradient(135deg, #1a2530 0%, #2c3e50 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    
    .btn-add-to-cart:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
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
        color: #2c3e50;
        border: 2px solid #2c3e50;
        padding: 10px 15px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s;
        width: 100%;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }
    
    .btn-view-details:hover {
        background-color: #2c3e50;
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
        color: #000;
        border-color: #ddd;
        margin: 0 5px;
        border-radius: 3px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #000;
        border-color: #000;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #f5f5f5;
    }
    
    .product-count {
        font-size: 14px;
        color: #666;
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
                <span>{{ $products->total() }} items</span>
            </div>
            
            <div class="d-flex">
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
            </div>
        </div>
        
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <div class="product-image">
                        @if($product->variants->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->variants->first()->product_image) }}" alt="{{ $product->product_name }}">
                        @else
                            <img src="{{ asset('image/placeholder.jpg') }}" alt="{{ $product->product_name }}">
                        @endif
                    </div>
                    <div class="product-info">
                        <h5 class="product-title">{{ $product->product_name }}</h5>
                        <div class="product-price-container">
                            <span class="product-original-price">RM{{ number_format($product->product_price, 2) }}</span>
                            <span class="product-price">RM{{ number_format($product->actual_price, 2) }}</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.view', $product->productID) }}" class="btn btn-view-details">View Details</a>
                            <button class="btn-add-to-cart" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
