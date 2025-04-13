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
    </style>
    @yield('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <img class="logo" src="{{ asset('image/IMG_7281-removebg-preview.png') }}" width="100px" alt="Logo">
        <div>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('products.customer') }}">Products</a>
            <a href="{{ url('/payment') }}">Shopping cart</a>
            <a href="{{ url('/about') }}">About us</a>
            <a href="{{ url('/contact') }}">Contact Us</a>
        </div>
        <div class="d-flex align-items-center">
            <div class="search-bar me-3">
                <input type="text" placeholder="Search" />
            </div>
            <a href="#"><img src="https://img.icons8.com/ios-glyphs/30/000000/like--v1.png" alt="Like"></a>
            <a href="#"><img src="https://img.icons8.com/ios-glyphs/30/000000/shopping-cart--v1.png" alt="Cart"></a>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@stack('scripts')  <!-- Add this line to render pushed scripts -->
</body>
</html>