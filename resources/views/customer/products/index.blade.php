@extends("layout.layout")
@section("css")
<<<<<<< HEAD
<!-- You can include your custom styles here -->
=======
<style>
    .product-section {
        padding: 60px 0;
        background-color: #f9f9f9;
    }
    
    .section-title {
        margin-bottom: 40px;
        position: relative;
    }
    
    .section-title h1 {
        font-size: 32px;
        font-weight: 600;
        color: #222;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }
    
    .section-title h1:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: #000;
    }
    
    .product-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .product-card .card-img-top {
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .product-card .card-body {
        padding: 20px;
    }
    
    .product-card .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #222;
    }
    
    .product-card .card-text {
        font-size: 16px;
        margin-bottom: 15px;
        color: #555;
    }
    
    .product-card .price {
        font-weight: 700;
        color: #000;
        font-size: 18px;
    }
    
    .btn-view-details {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }
    
    .btn-view-details:hover {
        background-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        color: #fff;
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #ff3366;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        z-index: 1;
    }
    
    .empty-products {
        padding: 60px 0;
        text-align: center;
    }
    
    .empty-products p {
        font-size: 18px;
        color: #777;
    }
    
    .filters-row {
        margin-bottom: 30px;
    }
    
    .filter-btn {
        background-color: #f1f1f1;
        color: #333;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        margin-right: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .filter-btn:hover, .filter-btn.active {
        background-color: #000;
        color: #fff;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
>>>>>>> master
@endsection

@section('title', 'Our Products')

@section('content')
<<<<<<< HEAD
<div class="container mt-5">
    <h1 class="text-center mb-4">Our Products</h1>

    @if(isset($message))
        <p>{{ $message }}</p>  <!-- Display the 'No products found' message -->
    @else
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">Price: RM {{ number_format($product->price, 2) }}</p>
                        <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No products available at the moment.</p>
            </div>
        @endforelse
    </div>
    @endif
=======
<div class="product-section">
    <div class="container">
        <div class="section-title text-center">
            <h1>Our Collection</h1>
        </div>
        
        <div class="filters-row text-center">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">New Arrivals</button>
            <button class="filter-btn">Best Sellers</button>
            <button class="filter-btn">Special Offers</button>
        </div>

        @if(isset($message))
            <div class="empty-products">
                <p>{{ $message }}</p>
            </div>
        @else
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card product-card h-100">
                        @if(rand(0,1))
                            <span class="product-badge">NEW</span>
                        @endif
                        <!-- Replace this line in the products loop -->
                        <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('image/IMG_7282.jpg') }}" class="card-img-top" alt="{{ $product->product_name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text price">RM {{ number_format($product->product_price, 2) }}</p>
                            <a href="{{ url('/products/' . $product->productID) }}" class="btn btn-view-details">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 empty-products">
                    <p>No products available at the moment.</p>
                </div>
            @endforelse
        </div>
        @endif
    </div>
>>>>>>> master
</div>
@endsection
