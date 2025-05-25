@extends('layout.admin_layout')
@section('title', 'Edit Product Variant')

@section('content')
<div class="container-fluid px-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit me-2"></i>Edit Product Variant</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Edit Variant</li>
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

    <form action="{{ route('products.variants.update', $variant->product_variantID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Product Variant Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Variant Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="colorID" class="form-label">Color</label>
                            <div class="color-radio-grid">
                                @foreach($colors as $color)
                                    <div class="color-radio-item">
                                        <input type="radio" 
                                               class="btn-check visually-hidden" 
                                               id="color_{{ $color->colorID }}" 
                                               name="colorID" 
                                               value="{{ $color->colorID }}" 
                                               {{ $variant->colorID == $color->colorID ? 'checked' : '' }}
                                               required>
                                        <label class="color-btn" 
                                               for="color_{{ $color->colorID }}" 
                                               style="background-color: {{ $color->color_code }};">
                                        </label>
                                        <span class="color-label">{{ $color->color_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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
                                           id="tone_{{ $tone->toneID }}" 
                                           name="tones[]" 
                                           value="{{ $tone->toneID }}"
                                           {{ $variant->tones->contains('toneID', $tone->toneID) ? 'checked' : '' }}>
                                    <label class="tone-btn" 
                                           for="tone_{{ $tone->toneID }}" 
                                           style="background-color: {{ $tone->tone_code }};">
                                    </label>
                                    <span class="tone-label">{{ $tone->tone_name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Sizes & Stock Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-ruler me-2"></i>Sizes & Stock</h6>
                <button type="button" class="btn btn-sm btn-primary add-size"><i class="fas fa-plus me-2"></i>Add Size</button>
            </div>
            <div class="card-body">
                <div id="sizes-container">
                    @foreach($variant->productSizings as $sizing)
                        <div class="row mb-3 size-item">
                            <div class="col-md-5">
                                <select class="form-select" name="sizes[]" required>
                                    <option value="">Select Size</option>
                                    <option value="XS" {{ $sizing->product_size == 'XS' ? 'selected' : '' }}>XS</option>
                                    <option value="S" {{ $sizing->product_size == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ $sizing->product_size == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ $sizing->product_size == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ $sizing->product_size == 'XL' ? 'selected' : '' }}>XL</option>
                                </select>
                                <input type="hidden" name="sizing_ids[]" value="{{ $sizing->product_sizingID }}">
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" name="stocks[]" value="{{ $sizing->product_stock }}" placeholder="Stock quantity" required min="0">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-size" data-sizing-id="{{ $sizing->product_sizingID }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Variant Images Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-images me-2"></i>Variant Images</h6>
                <button type="button" class="btn btn-sm btn-primary add-image"><i class="fas fa-plus me-2"></i>Add Image</button>
            </div>
            <div class="card-body">
                <div class="row" id="images-container">
                    @foreach($variant->variantImages as $image)
                        <div class="col-md-3 mb-3 image-item">
                            <div class="card">
                                <img src="{{ Storage::url($image->product_image) }}" class="card-img-top" alt="Variant Image">
                                <div class="card-body text-center">
                                    <input type="hidden" name="existing_images[]" value="{{ $image->variant_imageID }}">
                                    <button type="button" class="btn btn-danger remove-image" data-image-id="{{ $image->variant_imageID }}"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="new-images-container"></div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Variant</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Add new size row
        $('.add-size').click(function() {
            const newRow = `
                <div class="row mb-3 size-item">
                    <div class="col-md-5">
                        <select class="form-select" name="new_sizes[]" required>
                            <option value="">Select Size</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="new_stocks[]" placeholder="Stock quantity" required min="0">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-size"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            $('#sizes-container').append(newRow);
        });

        // Validate duplicate sizes
        $(document).on('change', 'select[name="sizes[]"], select[name="new_sizes[]"]', function() {
            const selectedSize = $(this).val();
            const currentSelect = $(this);
            
            if (selectedSize) {
                const existingSizes = $('select[name="sizes[]"], select[name="new_sizes[]"]')
                    .not(currentSelect)
                    .map(function() {
                        return $(this).val();
                    }).get();
                
                if (existingSizes.includes(selectedSize)) {
                    alert('This size has already been added');
                    $(this).val('');
                }
            }
        });

        // Remove size row
        $(document).on('click', '.remove-size', function() {
            const sizingId = $(this).data('sizing-id');
            if (sizingId) {
                if (confirm('Are you sure you want to delete this size?')) {
                    // Add hidden input for deletion
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'delete_sizing_ids[]',
                        value: sizingId
                    }).appendTo('form');
                    $(this).closest('.size-item').remove();
                }
            } else {
                $(this).closest('.size-item').remove();
            }
        });

        // Add new image input
        $('.add-image').click(function() {
            const newImageInput = `
                <div class="col-md-3 mb-3 image-item">
                    <div class="card">
                        <div class="card-body">
                            <input type="file" class="form-control" name="new_images[]" accept="image/*" required>
                            <button type="button" class="btn btn-danger mt-2 remove-image"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            `;
            $('#new-images-container').append(newImageInput);
        });

        // Remove image
        $(document).on('click', '.remove-image', function() {
            const imageId = $(this).data('image-id');
            if (imageId) {
                if (confirm('Are you sure you want to delete this image?')) {
                    // Add hidden input for deletion
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'delete_image_ids[]',
                        value: imageId
                    }).appendTo('form');
                    $(this).closest('.image-item').remove();
                }
            } else {
                $(this).closest('.image-item').remove();
            }
        });
    });
</script>
@endpush
@endsection