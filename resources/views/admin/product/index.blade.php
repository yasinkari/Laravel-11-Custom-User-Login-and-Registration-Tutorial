@extends('layout.admin_layout')

<<<<<<< HEAD
@section('title', 'Product List')

@section('content')
    <h1>Product List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Visibility</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <!-- Display the product image -->
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100" height="100">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning">
                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('products.toggleVisibility', $product->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info">
                                {{ $product->is_visible ? 'Visible' : 'Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                    
                        <!-- Delete Form -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

=======
@section('title', 'Product Management')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Product Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Product
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Product List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->productID }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>RM {{ number_format($product->product_price, 2) }}</td>
                            <td>
                                <form action="{{ route('products.updateStatus', $product->productID) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="is_new_arrival" 
                                               {{ $product->is_new_arrival ? 'checked' : '' }} onChange="this.form.submit()">
                                        <label class="form-check-label">New Arrival</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="is_best_seller" 
                                               {{ $product->is_best_seller ? 'checked' : '' }} onChange="this.form.submit()">
                                        <label class="form-check-label">Best Seller</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="is_special_offer" 
                                               {{ $product->is_special_offer ? 'checked' : '' }} onChange="this.form.submit()">
                                        <label class="form-check-label">Special Offer</label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <!-- Existing action buttons -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
</style>
@endpush
>>>>>>> master
@endsection
