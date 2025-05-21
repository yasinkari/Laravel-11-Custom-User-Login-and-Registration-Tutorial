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
  
  /* Footer Styling */
  .footer {
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 50px 0 20px;
    margin-top: 50px;
  }
  
  .footer h5 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #2c3e50;
  }
  
  .footer ul {
    list-style: none;
    padding-left: 0;
  }
  
  .footer ul li {
    margin-bottom: 10px;
  }
  
  .footer ul li a {
    color: #7f8c8d;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  .footer ul li a:hover {
    color: #e74c3c;
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
  
  .social-icons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
  }
  
  .social-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #2c3e50;
    transition: all 0.3s ease;
  }
  
  .social-icons a:hover {
    background-color: #e74c3c;
    color: white;
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

<!-- Footer Section -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Quick Links -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h5>QUICKLINKS</h5>
        <ul>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Shipping Information</a></li>
          <li><a href="#">Exchange & Refund Policy</a></li>
        </ul>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
      
      <!-- Shop With Us -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h5>SHOP WITH US</h5>
        <ul>
          <li><a href="#">Sedondon Collection</a></li>
          <li><a href="#">Men's Collection</a></li>
          <li><a href="#">Women's Collection</a></li>
          <li><a href="#">Boys' Collection</a></li>
          <li><a href="#">Girls' Collection</a></li>
          <li><a href="#">Accessories Collection</a></li>
        </ul>
      </div>
      
      <!-- We Accept -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h5>WE ACCEPT</h5>
        <div class="payment-icons">
          <img src="{{asset('image/payment/maybank.png')}}" alt="Maybank">
          <img src="{{asset('image/payment/rhb.png')}}" alt="RHB Bank">
          <img src="{{asset('image/payment/fpx.png')}}" alt="FPX">
          <img src="{{asset('image/payment/visa.png')}}" alt="Visa">
        </div>
        
        <h5 class="mt-4">WE DELIVER BY</h5>
        <div class="delivery-icons">
          <img src="{{asset('image/delivery/dhl.png')}}" alt="DHL">
          <img src="{{asset('image/delivery/poslaju.png')}}" alt="PosLaju">
        </div>
      </div>
      
      <!-- Copyright Info -->
      <div class="col-md-3 col-sm-6 mb-4">
        <h5>ABOUT US</h5>
        <p>Nill Concept Store offers premium traditional and modern clothing for the whole family.</p>
        <p class="mt-3">© 2020–2025 Nill Concept Store Sdn Bhd.<br>All rights reserved.</p>
        <p class="privacy-text">
          When you visit our sites, services, applications, or messaging, our authorised service providers may use cookies, web beacons, and other similar technologies for storing information to help provide you with a better, faster and safer experience and for advertising purposes.
        </p>
      </div>
    </div>
    
    <div class="copyright">
      <p>© 2020–2025 Nill Concept Store Sdn Bhd. All rights reserved.</p>
    </div>
  </div>
</footer>
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
