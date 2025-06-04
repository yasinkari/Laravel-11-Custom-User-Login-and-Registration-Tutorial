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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);
    </style>

<style>
    html {
        scroll-behavior: smooth;
    }
    
    body {
        overflow-x: hidden;
    }
    
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
    }
    .navbar-custom {
      background-color: #fff;
      padding: 0.8rem 2rem;
      border-bottom: 1px solid #eaeaea;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
      border: 1px solid #e0e0e0;
      border-radius: 20px;
      padding-left: 1rem;
      padding-right: 2.5rem;
      transition: all 0.3s ease;
    }
    
    .search-input:focus {
      box-shadow: 0 0 0 0.25rem rgba(255, 99, 71, 0.25);
      border-color: rgba(255, 99, 71, 0.5);
    }
    
    .navbar-nav .nav-link {
      font-weight: 600;
      padding: 0.5rem 1rem;
      position: relative;
    }
    
    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 50%;
      background-color: #ff6347;
      transition: all 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover::after {
      width: 80%;
      left: 10%;
    }
    
    .dropdown-menu {
      border-radius: 0.25rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      border: none;
      padding: 0.5rem 0;
    }
    
    .dropdown-item {
      padding: 0.5rem 1.5rem;
      transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
      background-color: rgba(255, 99, 71, 0.1);
    }
    
    .dropdown-item i {
      color: #ff6347;
      width: 20px;
    }
    
    .badge {
      font-size: 0.6rem;
      font-weight: 600;
    }
    
    /* Make navbar sticky with smooth transition */
    .sticky-top {
      transition: all 0.3s ease;
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
.btn-primary-custom {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #fff;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  position: relative;
  overflow: hidden;
}

.btn-primary-custom:hover {
  background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
  color: #fff;
}

.btn-primary-custom:active {
  background: linear-gradient(135deg, #4c51bf 0%, #553c9a 100%);
  transform: translateY(0);
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary-custom:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
}

.btn-primary-custom:disabled {
  background: #e2e8f0;
  color: #a0aec0;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.btn-primary-custom::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}

.btn-primary-custom:hover::before {
  left: 100%;
}
#accountDropdown:hover, #accountDropdown:active, #accountDropdown:focus {
    background-color: transparent !important;
    box-shadow: none !important;
}
/* Responsive Navbar */
@media (max-width: 992px) { 
.navbar-custom {
    padding: 0.8rem 1rem;
}
.navbar-custom .logo {
    font-size: 1.3rem;
}
.navbar-custom a {
    margin: 0 0.5rem;
    font-size: 0.9rem;
}
.navbar-custom .search-bar input {
    padding: 0.4rem 0.8rem;
    width: 150px; /* Adjust search bar width */
}
.auth-links a {
    font-size: 0.8rem;
}

.navbar-nav .nav-link::after {
    display: none;
}

.dropdown-menu {
    border: none;
    box-shadow: none;
    padding-left: 1rem;
}

.auth-links {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.auth-links .btn {
    margin-bottom: 0.5rem;
}
}

@media (max-width: 768px) { /* Small devices (landscape phones, less than 768px) */
.navbar-custom {
    flex-direction: column;
    align-items: flex-start;
}
.navbar-custom > div:nth-child(2) { /* Nav links container */
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-top: 10px;
}
.navbar-custom > div:nth-child(2) a {
    margin: 0.5rem 0;
    padding: 0.5rem;
    border-bottom: 1px solid #f0f0f0;
}
.navbar-custom > div:nth-child(2) a:last-child {
    border-bottom: none;
}
.navbar-custom .d-flex.align-items-center { /* Search and auth links container */
    width: 100%;
    /* Keep these elements in a row on mobile */
    flex-direction: row;
    align-items: center;
    justify-content: space-between; /* Distribute space */
    margin-top: 10px;
    padding: 0 1rem; /* Add some horizontal padding */
}
.navbar-custom .search-bar {
    width: auto; /* Allow search bar to take necessary width */
    margin-bottom: 0; /* Remove bottom margin */
    flex-grow: 1; /* Allow search bar to grow */
    margin-right: 1rem; /* Add margin to the right of search bar */
}
.navbar-custom .search-bar input {
    width: 100%;
}
.auth-links {
    margin-left: 0 !important;
    margin-top: 0; /* Remove top margin */
    display: flex; /* Ensure auth links are in a row */
    align-items: center;
    gap: 10px; /* Add space between auth links */
}
.auth-links a {
    margin: 0; /* Remove default margin */
}
}

/* Responsive Footer */
@media (max-width: 768px) {
.footer .col-md-3, .footer .col-sm-6 {
    margin-bottom: 30px;
}
.footer h5 {
    font-size: 16px;
}
.social-icons a {
    width: 35px;
    height: 35px;
}
}

@media (max-width: 576px) {
    .navbar-custom {
        padding: 0.5rem;
    }
    .navbar-custom .logo {
        font-size: 1.2rem;
        align-self: center; /* Center logo on mobile */
        margin-bottom: 10px;
    }
    .footer {
        padding: 30px 0 10px;
    }
    .footer .row > div {
        text-align: center; /* Center footer content on mobile */
    }
    .social-icons {
        justify-content: center;
    }
    .footer .d-flex.gap-3 {
        justify-content: center;
    }
}
.btn-outline-secondary:hover,
.btn-outline-secondary:focus,
.btn-outline-secondary:active,
.btn-outline-secondary.active {
    background-color: transparent !important;
    color: #6c757d !important;
    border-color: #6c757d !important;
}
</style>
    @yield('css')
    <!-- In the head section -->
    <!-- Already included, which is good! -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Add this for improved animations and transitions -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <!-- Replace the existing navbar section with this improved version -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="logo" src="{{ asset('image/IMG_7281-removebg-preview.png') }}" width="100px" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Search bar for mobile (shows only on small screens) -->
            <div class="d-lg-none w-100 mt-2 mb-2">
                <form class="d-flex position-relative">
                    <input class="form-control me-2 rounded-pill search-input" type="search" placeholder="Search products..." aria-label="Search">
                    <button class="btn position-absolute end-0 bg-transparent border-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Main navigation links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.customer') }}">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
                    </li>
                    
                </ul>
                
                <!-- Search bar (hidden on small screens) -->
                <div class="d-none d-lg-block me-3 flex-grow-1 mx-lg-4" style="max-width: 400px;">
                    <form class="d-flex position-relative">
                        <input class="form-control me-2 rounded-pill search-input" type="search" placeholder="Search products..." aria-label="Search">
                        <button class="btn position-absolute end-0 bg-transparent border-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Right side icons -->
                <div class="d-flex align-items-center">
                    {{-- <!-- Wishlist with counter --> --}}
                    {{-- <div class="position-relative me-3">
                        <a href="#" class="nav-link">
                            <i class="far fa-heart fs-5"></i>
                            <span class="position-absolute top-0  badge rounded-pill bg-danger">0</span>
                        </a>
                    </div> --}}
                    
                    <!-- Cart with counter -->
                    <div class="position-relative me-3">
                        <a href="{{ route('cart.view') }}" class="nav-link">
                            <i class="fas fa-shopping-cart fs-5"></i>
                            <span id="cartBadge" class="position-absolute top-0 badge rounded-pill bg-danger">0</span>
                        </a>
                    </div>
                    
                    <!-- Account dropdown -->
                    <div class="auth-links">
                        @if(Auth::check())
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent !important;">
                                    <i class="far fa-user-circle fs-5 me-1"></i> {{ Auth::user()->user_name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown" style="overflow:hidden; margin:0;">
                                    <li><a class="dropdown-item" href="{{route("profile.index")}}"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{route('orders.index')}}"><i class="fas fa-box me-2"></i>My Orders</a></li>
                                    {{-- <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Wishlist</a></li> --}}
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2" style="background-color: transparent !important;">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary-custom">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index: 1100; display: none;">
        <div id="successToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
</body>
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
              <li><a href="{{ route('faq') }}">FAQ</a></li>
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
              <li><a href="{{ route('products.customer') }}">Men's Collection</a></li>
              <li><a href="{{ route('products.customer') }}">Men's Sampin</a></li>
              <li><a href="{{ route('products.customer') }}">Fragrance</a></li>
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
<script>
    /**
     * Show a customizable toast notification
     * @param {string} type - 'success' or 'error'
     * @param {string} message - The message to display
     * @param {object} options - Optional settings:
     *   - {number} duration - Auto-hide delay in ms (default: 5000)
     *   - {string} position - 'top', 'bottom', or 'center' (default: 'center')
     *   - {string} title - Custom title for the toast
     *   - {string} bgColor - Custom background color
     *   - {string} textColor - Custom text color
     */
    //  Modified showToast function
    function showToast(type, message, options = {}) {
        const defaults = {
            duration: 5000,
            position: 'center',
            title: type.charAt(0).toUpperCase() + type.slice(1),
            bgColor: type === 'success' ? '#28a745' : '#dc3545',
            textColor: '#fff'
        };

        const settings = {...defaults, ...options};
        const toastId = `toast-${Date.now()}`;
        const positionClass = {
            'top': 'top-0 start-50 translate-middle-x',
            'bottom': 'bottom-0 start-50 translate-middle-x',
            'center': 'top-50 start-50 translate-middle'
        }[settings.position] || 'top-50 start-50 translate-middle';

        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center position-fixed ${positionClass} p-3" 
                role="alert" aria-live="assertive" aria-atomic="true"
                style="z-index: 1100; background-color: ${settings.bgColor}; color: ${settings.textColor}; display: block;">
                <div class="d-flex">
                    <div class="toast-body">
                        ${settings.title ? `<strong>${settings.title}</strong><br>` : ''}
                        ${message}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" 
                            data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', toastHtml);
        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, {
            delay: settings.duration
        });

        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.style.display = 'none';
            toastEl.remove();
        });
    }
    
    // Example usage:
    // showToast('success', 'Item added to cart!');
    // showToast('error', 'Failed to add item', {duration: 3000, position: 'top'});
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        const successToast = document.getElementById('successToast');
        const toastBody = successToast.querySelector('.toast-body');
        toastBody.textContent = "{{ session('success') }}";
        const toast = new bootstrap.Toast(successToast);
        toast.show();
    });
    @endif

    @if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        const errorToast = document.getElementById('errorToast');
        const toastBody = errorToast.querySelector('.toast-body');
        toastBody.textContent = "{{ session('error') }}";
        const toast = new bootstrap.Toast(errorToast);
        toast.show();
    });
    @endif

    function updateCartBadge() {
        $.ajax({
            url: '{{ route("cart.count") }}',
            method: 'GET',
            success: function(response) {
                $('#cartBadge').text(response.count);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart count:', error);
            }
        });
    }

    // Update cart badge when page loads
    $(document).ready(function() {
        updateCartBadge();
    });

    // Update cart badge every 30 seconds
    setInterval(updateCartBadge, 30000);
    </script>
@stack('scripts')  <!-- Add this line to render pushed scripts -->
</body>
</html>


