@extends("layout.layout")
@section("css")
<style>
  /* Hero Carousel Styling */
  #productCarousel .carousel-item img {
    width: 100%;
    height: 500px;
    object-fit: cover;
  }
  
  #productCarousel .carousel-caption {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 20px;
    border-radius: 10px;
  }
  
  /* 2025 Collections Styling */
  .collections-section {
    padding: 60px 0;
    background-color: #f8f9fa;
  }
  
  .collections-section h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 40px;
    text-align: center;
    color: #2c3e50;
  }
  
  .collection-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    height: 500px;
  }
  
  .collection-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .collection-card:hover img {
    transform: scale(1.05);
  }
  
  .collection-content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 30px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
    text-align: center;
  }
  
  .collection-content h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
    text-transform: uppercase;
  }
  
  .shop-now-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .shop-now-btn:hover {
    background-color: #c0392b;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
  
  
  
  .payment-icons, .delivery-icons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
  }
  
  .payment-icons img, .delivery-icons img {
    height: 30px;
    object-fit: contain;
  }
  
  .copyright {
    text-align: center;
    padding-top: 20px;
    margin-top: 30px;
    border-top: 1px solid #e9ecef;
    color: #95a5a6;
    font-size: 14px;
  }
  
  
  
  .privacy-text {
    margin-top: 20px;
    color: #7f8c8d;
    font-size: 13px;
    line-height: 1.6;
  }
</style>
@endsection
@section("content")
 
<!-- Hero Section with NILL -->
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <!-- NILL Item 1 -->
    <div class="carousel-item active">
      <img src="{{asset('image/IMG_7282.jpg')}}" height="50px" alt="Baju Melayu Jauhar">
      <div class="carousel-caption">
        <h1>New Arrival: Baju Melayu Jauhar 1.0</h1>
        <p>Men's Collection - Stylish, Comfortable & Trendy</p>
        <a href="#" class="btn btn-primary-custom">Shop Now!</a>
      </div>
    </div>
    <!-- NILL Item 2 -->
    <div class="carousel-item">
      <img src="{{asset('image/imageProducts/IMG_1229.jpg')}}" height="50px" alt="Baju Melayu Habeeb">
      <div class="carousel-caption">
        <h1>Exclusive Jubah Release</h1>
        <p>Elegant Designs in Vibrant Colors</p>
        <a href="#" class="btn btn-primary-custom">Explore More</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- 2025 Collections Section -->
<section class="collections-section">
  <div class="container">
    <h2>2025 Collections</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="collection-card">
          <img src="{{asset('image/collections/baju-melayu-traditional.jpg')}}" alt="Baju Melayu Traditional Fit">
          <div class="collection-content">
            <h3>Baju Melayu<br>Traditional Fit</h3>
            <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="collection-card">
          <img src="{{asset('image/collections/sisters-collection.jpg')}}" alt="Sisters Collection">
          <div class="collection-content">
            <h3>Sisters</h3>
            <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Showcase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    
  </head>
  <body>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html>
