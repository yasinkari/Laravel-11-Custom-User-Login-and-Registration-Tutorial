@extends('layout.admin_layout')
@section('title', 'Edit Product')

@section('content')
<div class="container-fluid px-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit me-2"></i>Edit Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->productID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Product Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_type" class="form-label">Product Type</label>
                            <select class="form-control" id="product_type" name="product_type" required>
                                <option value="">Select Type</option>
                                <option value="Baju Melayu" {{ $product->product_type == 'Baju Melayu' ? 'selected' : '' }}>Baju Melayu</option>
                                <option value="Sampin" {{ $product->product_type == 'Sampin' ? 'selected' : '' }}>Sampin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Base Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="{{ old('product_price', $product->product_price) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="actual_price" class="form-label">Actual Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="actual_price" name="actual_price" value="{{ old('actual_price', $product->actual_price) }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="size_img" class="form-label">Size Chart Image</label>
                            <input type="file" class="form-control" id="size_img" name="size_img" accept="image/*">
                            @if($product->size_img)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($product->size_img) }}" alt="Size Chart" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="4" required>{{ old('product_description', $product->product_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Display Image</label>
                    <div class="row">
                        @foreach($product->variants as $variant)
                            @foreach($variant->variantImages as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="{{ Storage::url($image->product_image) }}" class="card-img-top" alt="Variant Image">
                                        <div class="card-body text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                       name="variant_imageID" 
                                                       value="{{ $image->variant_imageID }}" 
                                                       id="image_{{ $image->variant_imageID }}" 
                                                       {{ $product->variant_imageID == $image->variant_imageID ? 'checked' : '' }}>
                                                <label class="form-check-label" for="image_{{ $image->variant_imageID }}">
                                                    Select as Display Image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" {{ $product->is_visible ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible">Visible to Customers</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Product</button>
        </div>
    </form>
</div>
@endsection
