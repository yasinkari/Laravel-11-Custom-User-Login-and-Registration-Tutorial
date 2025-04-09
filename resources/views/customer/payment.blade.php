@extends('layout.layout')

@section('title', 'Payment')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Payment Page</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" id="cardNumber" name="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiration" class="form-label">Expiration Date</label>
                            <input type="text" id="expiration" name="expiration" class="form-control" placeholder="MM/YY" required>
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
