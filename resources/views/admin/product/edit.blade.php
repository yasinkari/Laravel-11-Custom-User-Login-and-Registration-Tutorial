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
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Base Price (RM)</label>
                                        <input type="number" class="form-control @error('product_price') is-invalid @enderror" 
                                               id="product_price" name="product_price" 
                                               value="{{ old('product_price', $product->product_price) }}" 
                                               step="0.01" min="0">
                                        <small class="form-text text-muted">Optional</small>
                                        @error('product_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="actual_price" class="form-label">Actual Price (RM)</label>
                                        <input type="number" class="form-control @error('actual_price') is-invalid @enderror" 
                                               id="actual_price" name="actual_price" 
                                               value="{{ old('actual_price', $product->actual_price) }}" 
                                               step="0.01" min="0" required>
                                        <div id="discount-indicator" class="mt-1 {{ $product->discount_percentage > 0 ? '' : 'd-none' }}">
                                            <span class="badge bg-danger">Discount: <span id="discount-percentage">{{ $product->discount_percentage }}</span>% OFF</span>
                                        </div>
                                        @error('actual_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Visibility</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" 
                                                   value="1" {{ $product->is_visible ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_visible">Product is visible to customers</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Product Description</label>
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="tone-swatch me-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->tone->tone_code }}; border: 1px solid #ddd;"></div>
                                                {{ $variant->tone->tone_name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-swatch me-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->color->color_code }}; border: 1px solid #ddd;"></div>
                                                {{ $variant->color->color_name }}
                                            </div>
                                        </td>
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
                            {{ $variants->links() }}
                        </div>
                    </div>
                </div>

                <!-- Add Variant Modal -->
                <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addVariantModalLabel">Add New Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- In the Add Variant Modal form -->
                            <form action="{{ route('products.variants.store', $product->productID) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tone</label>
                                            <select class="form-select tone-select" name="toneID" id="editToneID" required>
                                                <option value="">Select Tone</option>
                                                @foreach($tones as $tone)
                                                    <option value="{{ $tone->toneID }}" data-tone-name="{{ $tone->tone_name }}" data-tone-code="{{ $tone->tone_code }}">{{ $tone->tone_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="tone-indicator d-none mt-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="tone-swatch"></div>
                                                    <span class="tone-name ms-2"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Color</label>
                                            <select class="form-select color-select" name="colorID" id="editColorID" required>
                                                <option value="">Select Color</option>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->colorID }}" data-color-name="{{ $color->color_name }}" data-color-code="{{ $color->color_code }}">{{ $color->color_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="color-indicator d-none mt-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="color-swatch"></div>
                                                    <span class="color-name ms-2"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Size</label>
                                            <select class="form-select" name="product_size" id="editProductSize" required>
                                                <option value="">Select Size</option>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="product_stock" id="editProductStock" min="0" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Current Image</label>
                                            <div class="current-image-container mb-2">
                                                <img id="currentVariantImage" src="" alt="Current Variant" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                            </div>
                                            <label class="form-label">Update Image (Optional)</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*">
                                            <small class="form-text text-muted">Leave empty to keep the current image</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Variant</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Variant Confirmation Modal -->
                <div class="modal fade" id="deleteVariantModal" tabindex="-1" aria-labelledby="deleteVariantModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteVariantModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this variant? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form id="deleteVariantForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate discount percentage when base price or actual price changes
        const productPriceInput = document.getElementById('product_price');
        const actualPriceInput = document.getElementById('actual_price');
        const discountIndicator = document.getElementById('discount-indicator');
        const discountPercentage = document.getElementById('discount-percentage');

        function calculateDiscount() {
            const basePrice = parseFloat(productPriceInput.value) || 0;
            const actualPrice = parseFloat(actualPriceInput.value) || 0;
            
            if (basePrice > 0 && actualPrice > 0 && basePrice > actualPrice) {
                const discount = Math.round(((basePrice - actualPrice) / basePrice) * 100);
                discountPercentage.textContent = discount;
                discountIndicator.classList.remove('d-none');
            } else {
                discountIndicator.classList.add('d-none');
            }
        }

        if (productPriceInput && actualPriceInput) {
            productPriceInput.addEventListener('input', calculateDiscount);
            actualPriceInput.addEventListener('input', calculateDiscount);
        }

        // Tone and Color selection visualization in Add Variant Modal
        const toneSelects = document.querySelectorAll('.tone-select');
        const colorSelects = document.querySelectorAll('.color-select');

        toneSelects.forEach(select => {
            select.addEventListener('change', function() {
                const container = this.closest('.mb-3');
                const indicator = container.querySelector('.tone-indicator');
                const swatch = container.querySelector('.tone-swatch');
                const nameSpan = container.querySelector('.tone-name');
                
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const toneName = selectedOption.getAttribute('data-tone-name');
                    const toneCode = selectedOption.getAttribute('data-tone-code');
                    
                    swatch.style.backgroundColor = toneCode;
                    nameSpan.textContent = toneName;
                    indicator.classList.remove('d-none');
                } else {
                    indicator.classList.add('d-none');
                }
            });
        });

        colorSelects.forEach(select => {
            select.addEventListener('change', function() {
                const container = this.closest('.mb-3');
                const indicator = container.querySelector('.color-indicator');
                const swatch = container.querySelector('.color-swatch');
                const nameSpan = container.querySelector('.color-name');
                
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const colorName = selectedOption.getAttribute('data-color-name');
                    const colorCode = selectedOption.getAttribute('data-color-code');
                    
                    swatch.style.backgroundColor = colorCode;
                    nameSpan.textContent = colorName;
                    indicator.classList.remove('d-none');
                } else {
                    indicator.classList.add('d-none');
                }
            });
        });

        // Edit Variant functionality
        const editButtons = document.querySelectorAll('.edit-variant');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const variantId = this.getAttribute('data-variant-id');
                
                // Fetch variant data via AJAX
                fetch(`/admin/products/variants/${variantId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const variant = data.variant;
                            
                            // Set form action
                            const form = document.getElementById('editVariantForm');
                            form.action = `/admin/products/variants/${variantId}`;
                            
                            // Populate form fields
                            document.getElementById('editToneID').value = variant.toneID;
                            document.getElementById('editColorID').value = variant.colorID;
                            document.getElementById('editProductSize').value = variant.product_size;
                            document.getElementById('editProductStock').value = variant.product_stock;
                            
                            // Trigger change events to update visual indicators
                            const toneEvent = new Event('change');
                            const colorEvent = new Event('change');
                            document.getElementById('editToneID').dispatchEvent(toneEvent);
                            document.getElementById('editColorID').dispatchEvent(colorEvent);
                            
                            // Set current image
                            document.getElementById('currentVariantImage').src = variant.image_url;
                            
                            // Open modal
                            const modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                            modal.show();
                        } else {
                            alert('Failed to load variant data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while fetching variant data');
                    });
            });
        });

        // Delete Variant functionality
        const deleteButtons = document.querySelectorAll('.delete-variant');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const variantId = this.getAttribute('data-variant-id');
                const form = document.getElementById('deleteVariantForm');
                form.action = `/admin/products/variants/${variantId}`;
                
                const modal = new bootstrap.Modal(document.getElementById('deleteVariantModal'));
                modal.show();
            });
        });

        // Color suggestion system
        const toneSuggestionSelects = document.querySelectorAll('#addToneSuggestion, #editToneSuggestion');
        const colorSuggestionMappings = {
            'Fair': ['Pastel Pink', 'Soft Blue', 'Lavender', 'Mint Green', 'Peach'],
            'Light': ['Coral', 'Teal', 'Dusty Rose', 'Sage Green', 'Periwinkle'],
            'Medium': ['Burgundy', 'Olive Green', 'Navy Blue', 'Rust', 'Plum'],
            'Tan': ['Terracotta', 'Forest Green', 'Mustard', 'Brick Red', 'Camel'],
            'Deep': ['Royal Blue', 'Emerald Green', 'Ruby Red', 'Gold', 'Purple'],
            'Dark': ['Bright Red', 'Bright Yellow', 'Turquoise', 'Fuchsia', 'Cobalt Blue']
        };

        toneSuggestionSelects.forEach(select => {
            select.addEventListener('change', function() {
                const toneName = this.value;
                const modalId = this.id.includes('add') ? 'add' : 'edit';
                const suggestionsContainer = document.getElementById(`${modalId}ColorSuggestions`);
                const suggestedColorsList = document.getElementById(`${modalId}SuggestedColorsList`);
                
                if (toneName && colorSuggestionMappings[toneName]) {
                    suggestedColorsList.innerHTML = '';
                    
                    colorSuggestionMappings[toneName].forEach(colorName => {
                        // Find the color in the available colors
                        const colorSelect = document.querySelector(`#${modalId === 'add' ? '' : 'edit'}ColorID`);
                        let colorOption = null;
                        
                        for (let i = 0; i < colorSelect.options.length; i++) {
                            if (colorSelect.options[i].text === colorName) {
                                colorOption = colorSelect.options[i];
                                break;
                            }
                        }
                        
                        if (colorOption) {
                            const colorCode = colorOption.getAttribute('data-color-code');
                            const colorId = colorOption.value;
                            
                            const colorBadge = document.createElement('div');
                            colorBadge.className = 'color-suggestion-badge me-2 mb-2';
                            colorBadge.innerHTML = `
                                <div class="d-flex align-items-center p-2 border rounded" style="cursor: pointer;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: ${colorCode}; border: 1px solid #ddd;"></div>
                                    <span class="ms-2">${colorName}</span>
                                </div>
                            `;
                            
                            colorBadge.addEventListener('click', function() {
                                colorSelect.value = colorId;
                                const event = new Event('change');
                                colorSelect.dispatchEvent(event);
                            });
                            
                            suggestedColorsList.appendChild(colorBadge);
                        }
                    });
                    
                    suggestionsContainer.classList.remove('d-none');
                } else {
                    suggestionsContainer.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection
