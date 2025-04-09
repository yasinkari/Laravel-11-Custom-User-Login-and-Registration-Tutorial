@extends('layout.admin_layout')
@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
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

                <!-- Basic Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->productID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                               id="product_name" name="product_name" 
                                               value="{{ old('product_name', $product->product_name) }}" required>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Base Price (RM)</label>
                                        <input type="number" class="form-control @error('product_price') is-invalid @enderror" 
                                               id="product_price" name="product_price" 
                                               value="{{ old('product_price', $product->product_price) }}" 
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
                                                  rows="4" required>{{ old('product_description', $product->product_description) }}</textarea>
                                        @error('product_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Basic Info
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Variants Management Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Product Variants</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                            <i class="fas fa-plus-circle me-2"></i>Add New Variant
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Tone</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($variants as $variant)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ Storage::url($variant->product_image) }}" 
                                                     alt="Variant" class="img-thumbnail" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>{{ $variant->tone->tone_name }}</td>
                                        <td>{{ $variant->color->color_name }}</td>
                                        <td>{{ $variant->product_size }}</td>
                                        <td>{{ $variant->product_stock }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary edit-variant me-2" 
                                                    data-variant-id="{{ $variant->product_variantID }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-variant" 
                                                    data-variant-id="{{ $variant->product_variantID }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No variants found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $variants->firstItem() ?? 0 }} to {{ $variants->lastItem() ?? 0 }} 
                                of {{ $variants->total() }} entries
                            </div>
                            <div>
                                {{ $variants->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.product.partials.variant_modal')

                <!-- Replace the existing pagination section -->
                <x-table-pagination :data="$variants" />

                @push('scripts')
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const pagination = new AjaxPagination({
                        container: document.querySelector('.card'),
                        url: '{{ route('products.variants', $product->productID) }}',
                        onLoad: () => {
                            // Reinitialize any necessary event listeners
                            initializeVariantButtons();
                        }
                    });
                });
                
                function initializeVariantButtons() {
                    // Your existing variant button initialization code
                }
                </script>
                @endpush
            </div>
        </main>
    </div>
</div>
@endsection
