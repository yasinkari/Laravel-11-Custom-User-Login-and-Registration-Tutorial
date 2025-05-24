@extends('layout.admin_layout')
@section('title', 'Edit Product')

@section('content')
{{-- {{dd($variants)}} --}}
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->productID) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Basic Product Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label"><i class="fas fa-tag me-2"></i>Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_type" class="form-label"><i class="fas fa-tshirt me-2"></i>Product Type</label>
                            <select class="form-control" id="product_type" name="product_type" required>
                                <option value="">Select Type</option>
                                <option value="Baju Melayu" {{ $product->product_type == 'Baju Melayu' ? 'selected' : '' }}>Baju Melayu</option>
                                <option value="Sampin" {{ $product->product_type == 'Sampin' ? 'selected' : '' }}>Sampin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Base Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="{{ old('product_price', $product->product_price) }}">
                        </div>
                        <div class="mb-3">
                            <label for="actual_price" class="form-label"><i class="fas fa-money-bill-wave me-2"></i>Actual Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="actual_price" name="actual_price" value="{{ old('actual_price', $product->actual_price) }}" required>
                            <div id="discount-indicator" class="mt-1 {{ $product->discount_percentage > 0 ? '' : 'd-none' }}">
                                <span class="badge bg-danger">Discount: <span id="discount-percentage">{{ $product->discount_percentage }}</span>% OFF</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="size_img" class="form-label"><i class="fas fa-ruler me-2"></i>Size Chart Image</label>
                            @if($product->size_img)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($product->size_img) }}" alt="Current Size Chart" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="size_img" name="size_img">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" {{ $product->is_visible ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_visible"><i class="fas fa-eye me-2"></i>Visible to Customers</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="product_description" class="form-label"><i class="fas fa-align-left me-2"></i>Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="4" required>{{ old('product_description', $product->product_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="variantSection" class="{{ $product->product_type == 'Baju Melayu' || $product->product_type == 'Sampin' ? '' : 'd-none' }}">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cubes me-2"></i>Product Variants</h6>
                    <button type="button" class="btn btn-primary btn-sm" id="addVariant"><i class="fas fa-plus me-1"></i>Add Variant</button>
                </div>
                <div class="card-body" id="variantsContainer">
                    @foreach($product->variants as $index => $variant)
                        <div class="variant-item border rounded p-3 mb-3" data-variant-id="{{ $variant->product_variantID }}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0"><i class="fas fa-cube me-2"></i>Variant #{{ $index + 1 }}</h6>
                                <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fas fa-trash me-1"></i>Remove</button>
                            </div>

                            <!-- Color Selection -->
                            <div class="mb-4">
                                <label class="form-label">Color</label>
                                <div class="color-radio-grid">
                                    @foreach($colors as $color)
                                        <div class="color-radio-item">
                                            <input type="radio" 
                                                   class="btn-check visually-hidden" 
                                                   id="variant_color_{{ $index }}_{{ $color->colorID }}" 
                                                   name="variants[{{ $index }}][colorID]" 
                                                   value="{{ $color->colorID }}" 
                                                   {{ $variant->colorID == $color->colorID ? 'checked' : '' }}
                                                   required>
                                            <label class="color-btn" 
                                                   for="variant_color_{{ $index }}_{{ $color->colorID }}" 
                                                   style="background-color: {{ $color->color_code }};">
                                            </label>
                                            <span class="color-label">{{ $color->color_name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tones Collection Section -->
                            <div class="tones-section mb-4">
                                <label class="form-label">Tones Collection</label>
                                <div class="tone-grid">
                                    @foreach($tones as $tone)
                                        <div class="tone-item">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input visually-hidden" 
                                                       id="variant_tone_{{ $index }}_{{ $tone->toneID }}" 
                                                       name="variants[{{ $index }}][tones][]" 
                                                       value="{{ $tone->toneID }}"
                                                       {{ in_array($tone->toneID, $variant->tones->pluck('toneID')->toArray()) ? 'checked' : '' }}>
                                                <label class="tone-btn" 
                                                       for="variant_tone_{{ $index }}_{{ $tone->toneID }}" 
                                                       style="background-color: {{ $tone->tone_code }};">
                                                </label>
                                                <span class="tone-label">{{ $tone->tone_name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sizes & Stock Section -->
                            <div class="sizes-section mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label">Sizes & Stock</label>
                                    <button type="button" class="btn btn-info btn-sm add-size"><i class="fas fa-plus me-1"></i>Add Size</button>
                                </div>
                                <div class="sizes-container">
                                    @foreach($variant->productSizings as $sizeIndex => $sizing)
                                        <div class="size-item row align-items-end mb-3">
                                            <div class="col-md-5">
                                                <label class="form-label">Size</label>
                                                <select class="form-select" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][size]" required>
                                                    <option value="">Select Size</option>
                                                    <option value="XS" {{ $sizing->product_size == 'XS' ? 'selected' : '' }}>XS</option>
                                                    <option value="S" {{ $sizing->product_size == 'S' ? 'selected' : '' }}>S</option>
                                                    <option value="M" {{ $sizing->product_size == 'M' ? 'selected' : '' }}>M</option>
                                                    <option value="L" {{ $sizing->product_size == 'L' ? 'selected' : '' }}>L</option>
                                                    <option value="XL" {{ $sizing->product_size == 'XL' ? 'selected' : '' }}>XL</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Stock</label>
                                                <input type="number" class="form-control" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][stock]" value="{{ $sizing->product_stock }}" required min="0">
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-size"><i class="fas fa-trash me-1"></i>Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="images-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label">Variant Images</label>
                                    <button type="button" class="btn btn-info btn-sm add-image"><i class="fas fa-plus me-1"></i>Add Image</button>
                                </div>
                                <div class="images-container">
                                    @foreach($variant->variantImages as $imageIndex => $image)
                                        <div class="image-item row align-items-end mb-3">
                                            <div class="col-md-10">
                                                @if($image->product_image)
                                                    {{-- Debug output --}}
                                                    <div class="d-none">Image Path: {{ Storage::url($image->product_image) }}</div>
                                                    <div class="mb-2">
                                                        <img src="{{ Storage::url($image->product_image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 100px">
                                                    </div>
                                                @endif
                                                <label class="form-label">Update Image</label>
                                                <input type="file" class="form-control" name="variants[{{ $index }}][images][{{ $imageIndex }}][file]" accept="image/*">
                                                <input type="hidden" name="variants[{{ $index }}][images][{{ $imageIndex }}][id]" value="{{ $image->id }}">
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-image"><i class="fas fa-trash me-1"></i>Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Product</button>
        </div>
    </form>
</div>

<!-- Variant Template for JavaScript Cloning -->
<template id="variantTemplate">
    <!-- Same template structure as in create.blade.php -->
</template>

@endsection

@push('scripts')
<script>
    // Same JavaScript as in create.blade.php with modifications for edit functionality
    // Add your JavaScript code here
</script>
@endpush
