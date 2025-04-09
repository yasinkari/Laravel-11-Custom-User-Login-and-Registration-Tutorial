@extends("layout.layout")
@section("css")

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
