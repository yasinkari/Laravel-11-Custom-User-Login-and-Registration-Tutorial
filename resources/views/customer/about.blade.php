@extends('layout.layout')

@section('content')
<div class="container my-5">
    <h1 class="text-center">About NILL</h1>
    <p class="text-center">
        Welcome to NILL! We are dedicated to providing top-quality, stylish Baju Melayu and traditional wear.
    </p>
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>
                At NILL, our mission is to blend traditional elegance with modern style. We are committed to offering premium quality clothing at affordable prices.
            </p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('image/IMG_7282.jpg') }}" class="img-fluid rounded" alt="About NILL">
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Our Story</h3>
            <p>
                NILL was founded in 2020 with a vision to redefine traditional clothing for the modern man. With a focus on quality craftsmanship and timeless design, our collections are inspired by cultural heritage and contemporary trends.
            </p>
        </div>
    </div>
</div>
@endsection
