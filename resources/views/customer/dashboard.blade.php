@extends("layout.layout")
@section("css")
<style>
  /* Global Styling */
  body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
  }
  
  /* Hero Carousel Styling - Professional Enhancement */
  #productCarousel {
    position: relative;
    overflow: hidden;
    border-radius: 0;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  }
  
  .carousel-image {
    height: 600px;
    object-fit: cover;
    filter: brightness(0.75) contrast(1.1);
    transition: all 0.8s ease;
  }
  
  .carousel-item:hover .carousel-image {
    transform: scale(1.02);
    filter: brightness(0.8) contrast(1.15);
  }
  
  .carousel-caption {
    background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 40%, rgba(0,0,0,0.3) 70%, transparent 100%);
    bottom: 0;
    left: 0;
    right: 0;
    padding: 4rem 2rem 3rem;
    text-align: center;
    border-radius: 0;
  }
  
  .carousel-title {
    font-size: 3.2rem;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
    margin-bottom: 1.2rem;
    letter-spacing: -0.02em;
    line-height: 1.1;
  }
  
  .carousel-subtitle {
    font-size: 1.4rem;
    color: #f8f9fa;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    margin-bottom: 2rem;
    font-weight: 400;
    opacity: 0.95;
  }
  
  /* Enhanced Button Styling */
  .btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
  }
  
  .btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s;
  }
  
  .btn-primary-custom:hover::before {
    left: 100%;
  }
  
  .btn-primary-custom:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    color: #ffffff;
  }
  
  /* Carousel Indicators Enhancement */
  .carousel-indicators {
    bottom: 30px;
    margin-bottom: 0;
  }
  
  .carousel-indicators button {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    margin: 0 8px;
    background-color: rgba(255,255,255,0.4);
    border: 3px solid rgba(255,255,255,0.8);
    transition: all 0.3s ease;
  }
  
  .carousel-indicators button.active {
    background-color: #667eea;
    border-color: #ffffff;
    transform: scale(1.2);
  }
  
  .carousel-indicators button:hover {
    background-color: rgba(255,255,255,0.7);
    transform: scale(1.1);
  }
  
  /* Enhanced Collections Section */
  .collections-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    position: relative;
  }
  
  .collections-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
  }
  
  .collections-section .container {
    position: relative;
    z-index: 2;
  }
  
  .collections-section h2 {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 60px;
    text-align: center;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: -0.02em;
    position: relative;
  }
  
  .collections-section h2::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
  }
  
  /* Professional Collection Cards - Faster Animations */
  /* Simplified Collection Cards - Minimal Animation */
  /* Global Styling */
  body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
  }
  
  /* Collection Cards - No Animation */
  .collection-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    margin-bottom: 40px;
    height: 550px;
    background: #ffffff;
  }
  
  .collection-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.9);
  }
  
  .collection-content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 40px 30px;
    background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, rgba(0,0,0,0.3) 80%, transparent 100%);
  }
  
  .collection-content h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 25px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    line-height: 1.2;
  }
  
  .shop-now-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }
  
  /* Enhanced Grid Layout */
  .collections-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    margin-top: 60px;
  }
  
  /* Professional Typography */
  .section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    text-align: center;
    margin-bottom: 50px;
    font-weight: 400;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }
  
  /* Enhanced Responsive Design */
  @media (max-width: 1200px) {
    .collections-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
    }
  }
  
  @media (max-width: 768px) {
    .collections-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    
    .collection-card {
      height: 400px;
      margin-bottom: 30px;
    }
    
    .collection-content {
      padding: 25px 20px;
    }
    
    .collection-content h3 {
      font-size: 1.8rem;
      margin-bottom: 15px;
    }
  }
  
  @media (max-width: 480px) {
    .shop-now-btn {
      padding: 12px 25px;
      font-size: 0.9rem;
    }
  }
</style>
@endsection

@section("content")
<!-- Professional Hero Carousel -->
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
  <div class="carousel-inner">
    <!-- Carousel Item 1 - Baju Melayu Jauhar -->
    <div class="carousel-item active">
      <img src="{{asset('image/IMG_7282.jpg')}}" class="d-block w-100 carousel-image" alt="Baju Melayu Jauhar">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="carousel-title">New Arrival: Baju Melayu Jauhar 1.0</h1>
        <p class="carousel-subtitle">Men's Collection - Stylish, Comfortable & Trendy</p>
        <a href="{{ route('products.customer') }}" class="btn btn-primary-custom btn-lg">Shop Now!</a>
      </div>
    </div>
    
    <!-- Carousel Item 2 - Exclusive Jubah -->
    <div class="carousel-item">
      <img src="{{asset('image/imageProducts/IMG_1229.JPG')}}" class="d-block w-100 carousel-image" alt="Exclusive Jubah">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="carousel-title">Exclusive Jubah Release</h1>
        <p class="carousel-subtitle">Elegant Designs in Vibrant Colors</p>
        <a href="{{ route('products.customer') }}" class="btn btn-primary-custom btn-lg">Explore More</a>
      </div>
    </div>
    
    <!-- Carousel Item 3 - Habeeb Collection -->
    <div class="carousel-item">
      <img src="{{asset('image/imageHomeBaju/HabeebEmeraldGreen2.jpg')}}" class="d-block w-100 carousel-image" alt="Habeeb Emerald Green">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="carousel-title">Habeeb Emerald Collection</h1>
        <p class="carousel-subtitle">Premium Quality Traditional Wear</p>
        <a href="{{ route('products.customer') }}" class="btn btn-primary-custom btn-lg">Discover Now</a>
      </div>
    </div>
    
    <!-- Carousel Item 4 - Jauhar Purple Collection -->
    <div class="carousel-item">
      <img src="{{asset('image/imageHomeBaju/JauharLilacPurple1.jpg')}}" class="d-block w-100 carousel-image" alt="Jauhar Lilac Purple">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="carousel-title">Jauhar Lilac Purple</h1>
        <p class="carousel-subtitle">Sophisticated Style for Modern Gentlemen</p>
        <a href="{{ route('products.customer') }}" class="btn btn-primary-custom btn-lg">Shop Collection</a>
      </div>
    </div>
  </div>
  
  <!-- Enhanced Carousel Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  
  <!-- Carousel Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Professional 2025 Collections Section -->
<section class="collections-section">
  <div class="container">
    <h2>2025 Collections</h2>
    <p class="section-subtitle">Discover our latest traditional wear collections, crafted with premium materials and modern designs for the contemporary gentleman.</p>
    
    <div class="collections-grid">
      <div class="collection-card">
        <img src="{{asset('image/imageHomeBaju/HabeebEmeraldGreen2.jpg')}}" alt="Baju Melayu Traditional Fit">
        <div class="collection-content">
          <h3>Baju Melayu<br>Traditional Fit</h3>
          <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
        </div>
      </div>
      
      <div class="collection-card">
        <img src="{{asset('image/imageHomeBaju/JauharLilacPurple1.jpg')}}" alt="Teluk Belanga Collection">
        <div class="collection-content">
          <h3>Teluk Belanga<br>Collection</h3>
          <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
        </div>
      </div>

      <div class="collection-card">
        <img src="{{asset('image/imageHomeBaju/(Habeeb)Black1.jpg')}}" alt="Men in Black Edition">
        <div class="collection-content">
          <h3>Men in Black<br>Edition</h3>
          <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
        </div>
      </div>

      <div class="collection-card">
        <img src="{{asset('image/imageHomeBaju/Maroon2.jpg')}}" alt="Maroon Collection">
        <div class="collection-content">
          <h3>Maroon<br>Collection</h3>
          <a href="{{ route('products.customer') }}" class="btn shop-now-btn">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

