@extends('layout.layout') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Payment Successful!</h4>
        <p>Your payment was processed successfully. Thank you for your order.</p>
        <hr>
        <p class="mb-0">You will receive an email confirmation shortly. You can also check your order status in your account.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection