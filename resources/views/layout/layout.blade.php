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