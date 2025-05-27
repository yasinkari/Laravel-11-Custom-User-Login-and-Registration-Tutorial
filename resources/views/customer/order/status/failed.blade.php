@extends('layout.layout') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Payment Failed or Cancelled</h4>
        <p>Unfortunately, your payment could not be processed or was cancelled.</p>
        <hr>
        <p class="mb-0">If you believe this is an error, please contact support. Otherwise, you can try placing your order again.</p>
        <a href="{{ route('cart.view') }}" class="btn btn-warning mt-3">Return to Cart</a>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection