@extends('layout.layout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Your Cart</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if($cart->cartRecords->isEmpty())
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>
        </div>
    @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Tone</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->cartRecords as $record)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($record->productVariant->product_image)
                                                <img src="{{ asset('storage/' . $record->productVariant->product_image) }}" 
                                                     alt="{{ $record->productVariant->product->product_name }}" 
                                                     class="img-thumbnail mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $record->productVariant->product->product_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $record->productVariant->tone->tone_name }}</td>
                                    <td>{{ $record->productVariant->color->color_name }}</td>
                                    <td>{{ $record->productVariant->product_size }}</td>
                                    <td>RM {{ number_format($record->productVariant->product->product_price, 2) }}</td>
                                    <td>
                                        <input type="number" name="quantities[{{ $record->cart_recordID }}]" 
                                               value="{{ $record->quantity }}" min="1" class="form-control" 
                                               style="width: 70px;">
                                    </td>
                                    <td>RM {{ number_format($record->productVariant->product->product_price * $record->quantity, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $record->cart_recordID) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                <td colspan="2"><strong>RM {{ number_format($cart->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
                <div>
                    <button type="submit" class="btn btn-primary mr-2">Update Cart</button>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection