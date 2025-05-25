<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NILLforMan - Your Premium Makeup Store">
    <meta name="keywords" content="makeup, cosmetics, beauty, men's makeup">
    <meta name="author" content="NILLforMan">
    <meta name="theme-color" content="#ffffff">
    <title>Laravel - NILLforMan.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);
    </style>

    <style>
        body {
          margin: 0;
          font-family: 'Arial', sans-serif;
        }
        .navbar-custom {
          background-color: #fff;
          padding: 1rem 3rem;
          border-bottom: 1px solid #eaeaea;
        }
        .navbar-custom .logo {
          font-size: 1.5rem;
          font-weight: bold;
        }
        .navbar-custom a {
          text-decoration: none;
          color: #333;
          font-weight: bold;
          margin: 0 1rem;
        }
        .navbar-custom .search-bar input {
          border: 1px solid #ccc;
          border-radius: 20px;
          padding: 0.5rem 1rem;
        }
        .carousel-item img {
          width: 100%;
          height: auto;
        }
        .carousel-caption {
          position: absolute;
          bottom: 30%;
          color: #fff;
          text-align: center;
        }
        .carousel-caption h1 {
          font-size: 3rem;
          font-weight: bold;
          text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
        .carousel-caption p {
          font-size: 1.2rem;
          text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .carousel-caption .btn {
          margin-top: 1rem;
          padding: 0.75rem 1.5rem;
          font-size: 1rem;
          border-radius: 30px;
        }
        .btn-primary-custom {
          background-color: #ff7f50;
          border: none;
        }
        .btn-primary-custom:hover {
          background-color: #ff6347;
        }
        .auth-links a {
          margin-left: 10px;
          text-decoration: none;
          font-size: 0.9rem;
          font-weight: bold;
          color: #ff6347;
        }
        .auth-links a:hover {
          text-decoration: underline;
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
  .product-details {
        padding: 60px 0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        min-height: 100vh;
    }

    /* Enhanced Product Image Section */
    .product-image {
        border-radius: 0;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        background: white;
        padding: 20px;
        margin-bottom: 30px;
        position: relative;
    }

    .product-image img {
        width: 100%;
        height: 500px;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-image:hover img {
        transform: scale(1.02);
    }
    
    /* Zoom icon overlay */
    .product-image:after {
        content: '\f00e';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(15, 44, 31, 0.7);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .product-image:hover:after {
        opacity: 1;
    }

    /* Enhanced Product Info Section */
    .product-info {
        padding: 40px;
        background: white;
        border-radius: 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #0f2c1f;
        margin-bottom: 20px;
        line-height: 1.2;
        position: relative;
        padding-bottom: 15px;
    }
    
    .product-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #0f2c1f, #2a5a4a);
    }

    .stock-status {
        display: inline-block;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 0;
        margin-bottom: 20px;
    }
    
    .stock-status.in-stock {
        background-color: rgba(15, 44, 31, 0.1);
        color: #0f2c1f;
        border: 1px solid rgba(15, 44, 31, 0.2);
    }
    
    .stock-status.out-of-stock {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    .product-price {
        font-size: 28px;
        font-weight: 700;
        color: #0f2c1f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 20px;
    }
    
    .new-price {
        color: #0f2c1f !important;
        font-weight: 700 !important;
    }

    .product-description {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.8;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #ecf0f1;
    }

    /* Enhanced Variant Section */
    .variant-section {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 0;
        margin-top: 30px;
        border: 1px solid rgba(15, 44, 31, 0.1);
    }

    .variant-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f2c1f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        padding-bottom: 10px;
    }
    
    .variant-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: #0f2c1f;
    }

    /* Enhanced Tone Selector */
    .tone-selector {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        margin-bottom: 35px;
        padding: 25px;
        background: white;
        border-radius: 0;
        position: relative;
        max-height: 120px;
        scrollbar-width: thin;
        scrollbar-color: #0f2c1f #f0f0f0;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .tone-selector::-webkit-scrollbar {
        height: 6px;
    }

    .tone-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 0;
    }

    .tone-selector::-webkit-scrollbar-thumb {
        background: #0f2c1f;
        border-radius: 0;
    }

    .tone-option {
        min-width: 50px;
        height: 50px;
        border-radius: 0;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .tone-option:hover {
        transform: scale(1.1);
        z-index: 1;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .tone-option.active {
        border-color: #0f2c1f;
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(15, 44, 31, 0.3);
    }

    .tone-option .tone-name {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 12px;
        background: rgba(15, 44, 31, 0.9);
        color: white;
        padding: 3px 8px;
        border-radius: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
        font-weight: 500;
    }

    .tone-option:hover .tone-name {
        opacity: 1;
    }

    /* Enhanced Color Selector */
    .color-selector {
        display: none;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        padding: 25px;
        background: white;
        border-radius: 0;
        margin-top: 30px;
        max-height: 120px;
        scrollbar-width: thin;
        scrollbar-color: #0f2c1f #f0f0f0;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .color-selector::-webkit-scrollbar {
        height: 6px;
    }

    .color-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 0;
    }

    .color-selector::-webkit-scrollbar-thumb {
        background: #0f2c1f;
        border-radius: 0;
    }

    .color-option {
        min-width: 50px;
        height: 50px;
        border-radius: 0;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .color-option:hover {
        transform: scale(1.1);
        z-index: 1;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .color-option.active {
        border-color: #0f2c1f;
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(15, 44, 31, 0.3);
    }

    .color-option .color-name {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 12px;
        background: rgba(15, 44, 31, 0.9);
        color: white;
        padding: 3px 8px;
        border-radius: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
        font-weight: 500;
    }

    .color-option:hover .color-name {
        opacity: 1;
    }
    
    /* Enhanced Variant Table */
    .variants-table {
        margin-top: 30px;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 0;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        background-color: rgba(15, 44, 31, 0.05);
        color: #0f2c1f;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        padding: 15px;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table tr:hover {
        background-color: rgba(15, 44, 31, 0.02);
    }
    
    /* Enhanced Quantity Input */
    .quantity-input {
        width: 70px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 0;
        font-size: 14px;
    }
    
    /* Enhanced Checkbox */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #0f2c1f;
    }
    
    /* Enhanced Add to Cart Button */
    .btn-add-to-cart {
        background-color: #0f2c1f;
        color: #fff;
        border: none;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 30px;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-add-to-cart:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: all 0.5s ease;
    }
    
    .btn-add-to-cart:hover {
        background-color: #143c2a;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }
    
    .btn-add-to-cart:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-add-to-cart:hover:before {
        left: 100%;
    }
    </style>
    @yield('css')
    <!-- In the head section -->
    <!-- Already included, which is good! -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Add this for improved animations and transitions -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <img class="logo" src="{{ asset('image/IMG_7281-removebg-preview.png') }}" width="100px" alt="Logo">
        <div>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('products.customer') }}">Products</a>
            <a href="{{ url('/about') }}">About us</a>
            <a href="{{ url('/contact') }}">Contact Us</a>
        </div>
        <div class="d-flex align-items-center">
            <div class="search-bar me-3">
                <input type="text" placeholder="Search" />
            </div>
            <a href="#"><img src="https://img.icons8.com/ios-glyphs/30/000000/like--v1.png" alt="Like"></a>
            <a href="{{ route('cart.view') }}"><img src="https://img.icons8.com/ios-glyphs/30/000000/shopping-cart--v1.png" alt="Cart"></a>
            <div class="auth-links ms-3">
                @if(Auth::check())
                    <a href="">Profile</a>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')
    <footer class="footer">
      <div class="container">
        <div class="row">
          <!-- Quick Links -->
          <div class="col-md-3 col-sm-6 mb-4">
            <h5>QUICKLINKS</h5>
            <ul>
              <li><a href="{{ route('contact') }}">Contact Us</a></li>
              <li><a href="#">Track Order</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Shipping Information</a></li>
              <li><a href="#">Exchange & Refund Policy</a></li>
            </ul>
            <div class="social-icons">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="https://www.instagram.com/nillforman/" target="_blank"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
          
          <!-- Shop With Us -->
          <div class="col-md-3 col-sm-6 mb-4">
            <h5>SHOP WITH US</h5>
            <ul>
              <li><a href="#">Men's Collection</a></li>
              <li><a href="#">Men's Sampin</a></li>
              <li><a href="#">Fragrance</a></li>
            </ul>
          </div>
          
          <!-- We Accept -->
          <div class="col-md-3 col-sm-6 mb-4">
            <h5 class="fw-bold mb-3">WE ACCEPT</h5>
            <div class="d-flex gap-3">
              <img src="{{asset('image/imageHomePageIcon/maybank.png')}}" alt="Maybank" width="48" height="48" style="object-fit: contain">
              <img src="{{asset('image/imageHomePageIcon/rhb.png')}}" alt="RHB Bank" width="48" height="48" style="object-fit: contain">
              <img src="{{asset('image/imageHomePageIcon/fpx.png')}}" alt="FPX" width="48" height="48" style="object-fit: contain">
              <img src="{{asset('image/imageHomePageIcon/visa.png')}}" alt="Visa" width="48" height="48" style="object-fit: contain">
            </div>
            
            <h5 class="fw-bold mb-3 mt-4">WE DELIVER BY</h5>
            <div class="d-flex gap-3">
              <img src="{{asset('image/imageHomePageIcon/dhl.png')}}" alt="DHL" width="48" height="48" style="object-fit: contain">
              <img src="{{asset('image/imageHomePageIcon/poslaju.png')}}" alt="PosLaju" width="48" height="48" style="object-fit: contain">
            </div>
          </div>
          
          <!-- Copyright Info -->
          <div class="col-md-3 col-sm-6 mb-4">
            <h5>ABOUT US</h5>
            <p>Nill Concept Store offers premium traditional and modern clothing for men.</p>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@stack('scripts')  <!-- Add this line to render pushed scripts -->
</body>
</html>