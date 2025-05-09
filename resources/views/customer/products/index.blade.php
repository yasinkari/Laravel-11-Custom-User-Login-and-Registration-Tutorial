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
    }
    
    .product-image img {
        object-fit: cover;
        height: 300px;
        width: 100%;
        transition: transform 0.5s;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
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
        background-color: #000;
        color: #fff;
        border: none;
        padding: 8px 15px;
        font-size: 12px;
        text-transform: uppercase;
        transition: background-color 0.3s;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .btn-add-to-cart:hover {
        background-color: #333;
        color: #fff;
    }
    
    .btn-view-details {
        background-color: transparent;
        color: #000;
        border: 1px solid #000;
        padding: 8px 15px;
        font-size: 12px;
        text-transform: uppercase;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-view-details:hover {
        background-color: #000;
        color: #fff;
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
                        <div class="product-discount-badge">32% OFF</div>
                    </div>
                    <div class="product-info">
                        <h5 class="product-title">{{ $product->product_name }}</h5>
                        <div class="product-price-container">
                            <span class="product-original-price">RM{{ number_format($product->product_price, 2) }}</span>
                            <span class="product-price">RM{{ number_format($product->actual_price, 2) }}</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.view', $product->productID) }}" class="btn btn-view-details">View Details</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->productID }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-add-to-cart">Add to Cart</button>
                            </form>
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
