@extends('layout.admin_layout')
@section('title', 'Add Product')

@section('content')
<<<<<<< HEAD
<h1 class="mb-4">Add New Product</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Product Name -->
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <!-- Price -->
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" id="image" name="image" class="form-control" required>
    </div>

    <!-- Variants Section -->
    <h3>Product Variants</h3>
    <div id="variant-fields">
        <!-- Variant input fields will be dynamically added here -->
        <div class="variant mb-4 p-3 border rounded shadow-sm">
            <h5>Variant 1</h5>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="variants[0][color]" class="form-control" value="{{ old('variants.0.color') }}" required>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="variants[0][size]" class="form-control" value="{{ old('variants.0.size') }}" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="variants[0][stock]" class="form-control" value="{{ old('variants.0.stock') }}" required>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-outline-secondary" onclick="addVariant()">Add Another Variant</button>

    <br><br>
    <button type="submit" class="btn btn-primary">Save Product</button>
</form>

<script>
    let variantCount = 1;

    function addVariant() {
        let variantHTML = `
            <div class="variant mb-4 p-3 border rounded shadow-sm">
                <h5>Variant ${variantCount + 1}</h5>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="variants[${variantCount}][color]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="variants[${variantCount}][size]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="variants[${variantCount}][stock]" class="form-control" required>
                </div>
            </div>
        `;
        document.getElementById('variant-fields').insertAdjacentHTML('beforeend', variantHTML);
        variantCount++;
    }
</script>

@endsection
=======
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Product</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        
        <div class="row">
            <!-- Basic Product Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" 
                                   value="{{ old('product_name') }}" required>
                            <div class="invalid-feedback">Please enter a product name.</div>
                        </div>

                        <div class="mb-4">
                            <label for="product_price" class="form-label">Price (RM)</label>
                            <div class="input-group">
                                <span class="input-group-text">RM</span>
                                <input type="number" class="form-control" id="product_price" name="product_price" 
                                       step="0.01" min="0" value="{{ old('product_price') }}" required>
                                <div class="invalid-feedback">Please enter a valid price.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="product_description" class="form-label">Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" 
                                      rows="4" required>{{ old('product_description') }}</textarea>
                            <div class="invalid-feedback">Please enter a product description.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Variants -->
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Product Variants</h5>
                        <button type="button" class="btn btn-primary btn-sm" id="add-variant">
                            <i class="fas fa-plus me-1"></i>Add Variant
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variants-container" class="variants-wrapper">
                            <!-- Variants will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Create Product
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Variant Template -->
    <template id="variant-template">
        <div class="variant-item border rounded-3 p-4 mb-4 position-relative bg-light">
            <div class="position-absolute top-0 end-0 p-3">
                <button type="button" class="btn btn-outline-danger btn-sm remove-variant">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <h6 class="mb-4 text-primary">Variant <span class="variant-number"></span></h6>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Tone</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select tone-select" name="variants[INDEX][toneID]" required>
                                <option value="">Select Tone</option>
                                @foreach($tones as $tone)
                                    <option value="{{ $tone->toneID }}" data-tone="{{ $tone->tone_code }}">
                                        {{ $tone->tone_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="tone-preview rounded-circle border" style="width: 30px; height: 30px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Replace the existing color select with this -->
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select color-select" name="variants[INDEX][colorID]" required>
                                <option value="">Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->colorID }}" data-color="{{ $color->color_code }}">
                                        {{ $color->color_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="color-preview rounded-circle border" style="width: 30px; height: 30px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Size</label>
                        <select class="form-select" name="variants[INDEX][product_size]" required>
                            <option value="">Select Size</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="variants[INDEX][product_stock]" min="0" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="variants[INDEX][product_image]" required 
                               accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@push('styles')
<style>
.variants-wrapper {
    transition: all 0.3s ease;
}
.variant-item {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,.125) !important;
}
.variant-item:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
}
.form-label {
    font-weight: 500;
    margin-bottom: .5rem;
}
.card {
    border: none;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    const container = $('#variants-container');
    const template = document.getElementById('variant-template');
    let variantCount = 0;

    // Add initial variant
    addVariant();

    // Add variant button click handler
    $('#add-variant').click(function() {
        addVariant();
    });

    // Remove variant button click handler using event delegation
    $(document).on('click', '.remove-variant', function() {
        if (container.children().length > 1) {
            $(this).closest('.variant-item').remove();
            updateVariantNumbers();
        } else {
            alert('At least one variant is required.');
        }
    });

    function addVariant() {
        const variantNode = template.content.cloneNode(true);
        const variantDiv = variantNode.querySelector('.variant-item');
        
        variantCount++;
        $(variantDiv).find('.variant-number').text(variantCount);
        
        // Update all name attributes with the correct index
        $(variantDiv).find('[name*="INDEX"]').each(function() {
            this.name = this.name.replace(/INDEX/g, (variantCount - 1));
        });

        container.append(variantDiv);
        updateVariantNumbers();
    }

    function updateVariantNumbers() {
        $('.variant-item').each(function(index) {
            $(this).find('.variant-number').text(index + 1);
            
            // Update indices when removing variants
            $(this).find('[name*="variants["]').each(function() {
                this.name = this.name.replace(/variants\[\d+\]/, `variants[${index}]`);
            });
        });
    }

    // Add color preview functionality
    $(document).on('change', '.color-select', function() {
        const selectedOption = $(this).find('option:selected');
        const colorPreview = $(this).closest('.d-flex').find('.color-preview');
        
        if (selectedOption.val()) {
            const colorCode = selectedOption.data('color');
            colorPreview.css('background-color', colorCode);
        } else {
            colorPreview.css('background-color', 'transparent');
        }
    });

    // Modify your existing addVariant function to trigger color preview
    const originalAddVariant = addVariant;
    addVariant = function() {
        originalAddVariant();
        $('.color-select').trigger('change');
    };
});
</script>
@endpush
@endsection

@push('styles')
<style>
.tone-preview {
    transition: background-color 0.3s ease;
    border-color: #dee2e6 !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add tone preview functionality
    $(document).on('change', '.tone-select', function() {
        const selectedOption = $(this).find('option:selected');
        const tonePreview = $(this).closest('.d-flex').find('.tone-preview');
        
        if (selectedOption.val()) {
            const toneCode = selectedOption.data('tone');
            tonePreview.css('background-color', toneCode);
        } else {
            tonePreview.css('background-color', 'transparent');
        }
    });

    // Modify your existing addVariant function to include tone preview
    const originalAddVariant = addVariant;
    addVariant = function() {
        originalAddVariant();
        $('.tone-select').trigger('change');
    };
});
</script>
@endpush
>>>>>>> master
