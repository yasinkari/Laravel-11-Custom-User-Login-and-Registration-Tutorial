@extends('layout.admin_layout')
@section('title', 'Add New Product')

@section('content')
<div class="container-fluid px-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-plus-circle me-2"></i>Add New Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Basic Product Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_name" class="form-label"><i class="fas fa-tag me-2"></i>Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_type" class="form-label"><i class="fas fa-tshirt me-2"></i>Product Type</label>
                            <select class="form-control" id="product_type" name="product_type" required>
                                <option value="">Select Type</option>
                                <option value="Baju Melayu">Baju Melayu</option>
                                <option value="Sampin">Sampin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Base Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="product_price" name="product_price">
                        </div>
                        <div class="mb-3">
                            <label for="actual_price" class="form-label"><i class="fas fa-money-bill-wave me-2"></i>Actual Price (RM)</label>
                            <input type="number" step="0.01" class="form-control" id="actual_price" name="actual_price" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="size_img" class="form-label"><i class="fas fa-ruler me-2"></i>Size Chart Image</label>
                            <input type="file" class="form-control" id="size_img" name="size_img">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" checked>
                                <label class="form-check-label" for="is_visible"><i class="fas fa-eye me-2"></i>Visible to Customers</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="product_description" class="form-label"><i class="fas fa-align-left me-2"></i>Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="variantSection" class="d-none">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cubes me-2"></i>Product Variants</h6>
                    <button type="button" class="btn btn-primary btn-sm" id="addVariant"><i class="fas fa-plus me-1"></i>Add Variant</button>
                </div>
                <div class="card-body" id="variantsContainer">
                    <!-- Variant template will be cloned here -->
                </div>
            </div>

            <!-- Variant Template -->
            <template id="variantTemplate">
                <div class="variant-item border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0"><i class="fas fa-cube me-2"></i>Variant #<span class="variant-number">1</span></h6>
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
                                           id="variant_color_0_{{ $color->colorID }}" 
                                           name="variants[0][colorID]" 
                                           value="{{ $color->colorID }}" 
                                           required>
                                    <label class="color-btn" 
                                           for="variant_color_0_{{ $color->colorID }}" 
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
                                               id="variant_tone_0_{{ $tone->toneID }}" 
                                               name="variants[0][tones][]" 
                                               value="{{ $tone->toneID }}">
                                        <label class="tone-btn" 
                                               for="variant_tone_0_{{ $tone->toneID }}" 
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
                            <div class="size-item row align-items-end mb-3">
                                <div class="col-md-5">
                                    <label class="form-label">Size</label>
                                    <select class="form-select" name="variants[0][sizes][0][size]" required>
                                        <option value="">Select Size</option>
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Stock</label>
                                    <input type="number" class="form-control" name="variants[0][sizes][0][stock]" placeholder="Stock" required min="0">
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-size"><i class="fas fa-trash me-1"></i>Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div class="images-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label">Variant Images</label>
                            <button type="button" class="btn btn-info btn-sm add-image"><i class="fas fa-plus me-1"></i>Add Image</button>
                        </div>
                        <div class="images-container">
                            <div class="image-item row align-items-end mb-3">
                                <div class="col-md-10">
                                    <label class="form-label" for="variant_image_0_0">Image</label>
                                    <input type="file" class="form-control" id="variant_image_0_0" name="variants[0][images][]" required accept="image/*">
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-image" aria-label="Remove Image"><i class="fas fa-trash me-1"></i>Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Create Product</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Show/hide variant section based on product type
        $('#product_type').change(function() {
            const type = $(this).val();
            if (type === 'Baju Melayu' || type === 'Sampin') {
                $('#variantSection').removeClass('d-none');
            } else {
                $('#variantSection').addClass('d-none');
            }
        });

        // Add new variant
        $('#addVariant').click(function() {
            const template = document.querySelector('#variantTemplate');
            const clone = template.content.cloneNode(true);
            const variantCount = $('#variantsContainer .variant-item').length;
            
            // Update variant number, IDs and names
            $(clone).find('.variant-number').text(variantCount + 1);
            $(clone).find('[name^="variants[0]"]').each(function() {
                const newName = $(this).attr('name').replace('variants[0]', `variants[${variantCount}]`);
                $(this).attr('name', newName);
                
                // Update IDs for labels
                if ($(this).attr('id')) {
                    // Handle size radio button IDs specifically
                    if ($(this).attr('id').startsWith('variant_size_0_0_')) {
                         const sizeValue = $(this).val();
                         const newId = `variant_size_${variantCount}_0_${sizeValue}`;
                         $(this).attr('id', newId);
                         $(this).next('label').attr('for', newId);
                    } else if ($(this).attr('id').startsWith('variant_color_')) {
                        const colorId = $(this).attr('id').split('_').pop();
                        const newColorId = `variant_color_${variantCount}_${colorId}`;
                        $(this).attr('id', newColorId);
                        $(this).next('label').attr('for', newColorId);
                    } else {
                        const newId = $(this).attr('id').replace('_0', `_${variantCount}`);
                        $(this).attr('id', newId);
                        // Update tone checkbox IDs specifically
                        if (newId.startsWith('variant_tone_')) {
                            $(this).next('label').attr('for', newId);
                        } else {
                            $(this).prev('label').attr('for', newId);
                        }
                    }
                }
            });
    
            // Remove Select2 initialization as it's no longer needed for tones
            $('#variantsContainer').append(clone);
        });

        // Add size with proper IDs
        $(document).on('change', 'select[name*="[size]"]', function() {
            const sizeSelect = $(this);
            const selectedSize = sizeSelect.val();
            const variantContainer = sizeSelect.closest('.variant-item');
            
            if (selectedSize) {
                // Check for duplicate sizes in this variant
                const existingSizes = variantContainer.find('select[name*="[size]"]').not(sizeSelect).map(function() {
                    return $(this).val();
                }).get();
                
                if (existingSizes.includes(selectedSize)) {
                    alert('This size has already been added to this variant');
                    sizeSelect.val('');
                }
            }
        });

        // Updated add-size handler with validation
        $(document).on('click', '.add-size', function() {
            const variantIndex = $(this).closest('.variant-item').index();
            const sizeCount = $(this).closest('.sizes-section').find('.size-item').length;
            
            // Check if all existing sizes are selected
            const hasEmptySizes = $(this).closest('.sizes-section').find('select[name*="[size]"]').filter(function() {
                return $(this).val() === '';
            }).length > 0;
            
            if (hasEmptySizes) {
                alert('Please select sizes for all existing size fields before adding new ones');
                return;
            }
            
            // Rest of the add-size implementation
            const sizeHtml = `
                <div class="size-item row align-items-end mb-3">
                    <div class="col-md-5">
                        <label class="form-label">Size</label>
                        <select class="form-select" name="variants[${variantIndex}][sizes][${sizeCount}][size]" required>
                            <option value="">Select Size</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="variants[${variantIndex}][sizes][${sizeCount}][stock]" placeholder="Stock" required min="0">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger btn-sm remove-size"><i class="fas fa-trash me-1"></i>Remove</button>
                    </div>
                </div>
            `;
            $(this).closest('.sizes-section').find('.sizes-container').append(sizeHtml);
        });

        // Add image with proper IDs
        $(document).on('click', '.add-image', function() {
            const variantIndex = $(this).closest('.variant-item').index();
            const imageCount = $(this).closest('.images-section').find('.image-item').length;
            const imageHtml = `
                <div class="image-item row align-items-end mb-3">
                    <div class="col-md-10">
                        <label class="form-label" for="variant_image_${variantIndex}_${imageCount}">Image</label>
                        <input type="file" class="form-control" id="variant_image_${variantIndex}_${imageCount}" name="variants[${variantIndex}][images][]" required accept="image/*">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger btn-sm remove-image" aria-label="Remove Image">Remove</button>
                    </div>
                </div>
            `;
            $(this).closest('.images-section').find('.images-container').append(imageHtml);
        });

        // Remove variant handler
        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.variant-item').remove();
            // Update variant numbers after removal
            $('.variant-item').each(function(index) {
                $(this).find('.variant-number').text(index + 1);
            });
        });

        // Remove size handler
        $(document).on('click', '.remove-size', function() {
            const sizesContainer = $(this).closest('.sizes-container');
            if (sizesContainer.find('.size-item').length > 1) {
                $(this).closest('.size-item').remove();
            } else {
                alert('At least one size must be maintained.');
            }
        });

        // Remove image handler
        $(document).on('click', '.remove-image', function() {
            const imagesContainer = $(this).closest('.images-container');
            if (imagesContainer.find('.image-item').length > 1) {
                $(this).closest('.image-item').remove();
            } else {
                alert('At least one image is required.');
            }
        });
    });
</script>
@endpush
@endsection
