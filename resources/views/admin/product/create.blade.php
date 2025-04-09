@extends('layout.admin_layout')
@section('title', 'Add New Product')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add New Product</li>
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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Product Basic Info Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                   id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_price" class="form-label">Base Price (RM)</label>
                            <input type="number" class="form-control @error('product_price') is-invalid @enderror" 
                                   id="product_price" name="product_price" value="{{ old('product_price') }}" 
                                   step="0.01" min="0" required>
                            @error('product_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Description</label>
                            <textarea class="form-control @error('product_description') is-invalid @enderror" 
                                      id="product_description" name="product_description" 
                                      rows="4" required>{{ old('product_description') }}</textarea>
                            @error('product_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Variants Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Product Variants</h6>
                <button type="button" class="btn btn-sm btn-primary" id="addVariant">
                    <i class="fas fa-plus-circle me-1"></i>Add Variant
                </button>
            </div>
            <div class="card-body">
                <div id="variantsContainer" class="variants-grid">
                    <!-- Variants will be added here dynamically -->
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Product
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.variants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}
</style>
@endsection

<!-- Variant Template -->
<template id="variantTemplate">
    <div class="variant-item border rounded p-3 mb-3">
        <div class="d-flex justify-content-between mb-3">
            <h6 class="mb-0">Variant #<span class="variant-number"></span></h6>
            <button type="button" class="btn btn-sm btn-danger remove-variant">Remove</button>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tone</label>
                <select class="form-select" name="variants[__index__][toneID]" required>
                    <option value="">Select Tone</option>
                    @foreach($tones as $tone)
                        <option value="{{ $tone->toneID }}">{{ $tone->tone_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Color</label>
                <select class="form-select" name="variants[__index__][colorID]" required>
                    <option value="">Select Color</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->colorID }}">{{ $color->color_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Size</label>
                <select class="form-select" name="variants[__index__][product_size]" required>
                    <option value="">Select Size</option>
                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Stock</label>
                <input type="number" class="form-control" name="variants[__index__][product_stock]" 
                       min="0" required>
            </div>
            <div class="col-12">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="variants[__index__][product_image]" 
                       accept="image/*" required>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('variantsContainer');
    const template = document.getElementById('variantTemplate');
    let variantCount = 0;

    function addVariant() {
        const variantContent = template.content.cloneNode(true);
        const variantDiv = variantContent.querySelector('.variant-item');
        
        // Update variant number and indices
        variantCount++;
        variantDiv.querySelector('.variant-number').textContent = variantCount;
        variantDiv.innerHTML = variantDiv.innerHTML.replace(/__index__/g, variantCount - 1);

        // Add remove functionality
        variantDiv.querySelector('.remove-variant').addEventListener('click', function() {
            variantDiv.remove();
            updateVariantNumbers();
        });

        container.appendChild(variantDiv);
    }

    function updateVariantNumbers() {
        const variants = container.querySelectorAll('.variant-item');
        variants.forEach((variant, index) => {
            variant.querySelector('.variant-number').textContent = index + 1;
        });
    }

    document.getElementById('addVariant').addEventListener('click', addVariant);

    // Add first variant automatically
    addVariant();
});
</script>
@endpush
@endsection
