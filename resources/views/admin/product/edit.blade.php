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
                                               step="0.01" min="0" required>
                                        @error('product_price')
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
                                            <select class="form-select tone-select" name="toneID" required>
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
                                            <select class="form-select color-select" name="colorID" required>
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
                                            <select class="form-select" name="product_size" required>
                                                <option value="">Select Size</option>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="product_stock" min="0" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Variant</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Variant Modal -->
                <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVariantModalLabel">Edit Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editVariantForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <!-- Color Suggestion Panel -->
                                    <div class="card mb-4 border-left-info">
                                        <div class="card-body">
                                            <h6 class="font-weight-bold text-info mb-3">Color Suggestions by Skin Tone</h6>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="editToneSuggestion">Select Skin Tone</label>
                                                        <select class="form-select" id="editToneSuggestion">
                                                            <option value="">Select a tone for suggestions</option>
                                                            @foreach($tones as $tone)
                                                                <option value="{{ $tone->tone_name }}">{{ $tone->tone_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div id="editColorSuggestions" class="d-none">
                                                        <label>Suggested Colors:</label>
                                                        <div class="d-flex flex-wrap" id="editSuggestedColorsList">
                                                            <!-- Suggested colors will appear here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Form fields will be populated dynamically -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tone</label>
                                            <select class="form-select tone-select" name="toneID" id="edit_toneID" required>
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
                                            <select class="form-select color-select" name="colorID" id="edit_colorID" required>
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
                                            <select class="form-select" name="product_size" id="edit_product_size" required>
                                                <option value="">Select Size</option>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="product_stock" id="edit_product_stock" min="0" required>
                                        </div>
                                        <!-- Inside the edit modal form -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Current Image</label>
                                            <img id="current_variant_image" src="" alt="Current Variant Image" 
                                                 class="img-thumbnail mb-2" style="max-width: 200px;">
                                            <label class="form-label">New Image (optional)</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*">
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
                                Are you sure you want to delete this variant? This action cannot be undone.
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

                @push('scripts')
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Color suggestions data
                    const colorSuggestions = {
                        'Fair': {
                            'Navy': '#000080',
                            'Brown': '#8B4513',
                            'Burgundy': '#800020',
                            'Green': '#006400',
                            'Olive': '#808000'
                        },
                        'Olive': {
                            'Burgundy': '#800020',
                            'Maroon': '#800000',
                            'Purple': '#800080',
                            'Green': '#006400',
                            'Navy': '#000080'
                        },
                        'Light Brown': {
                            'Navy': '#000080',
                            'Royal Blue': '#4169E1',
                            'Teal': '#008080',
                            'Grey': '#808080',
                            'Burgundy': '#800020'
                        },
                        'Brown': {
                            'Navy': '#000080',
                            'Mid Blue': '#0000CD',
                            'Green': '#006400',
                            'Bright Yellow': '#FFFF00',
                            'Sky Blue': '#87CEEB'
                        },
                        'Black Brown': {
                            'Black': '#000000',
                            'Navy': '#000080',
                            'Burgundy': '#800020',
                            'Pink': '#FFC0CB',
                            'Pastel Blue': '#ADD8E6'
                        }
                    };
                    
                    // Setup tone suggestion dropdown for edit modal
                    const editToneSelect = document.getElementById('editToneSuggestion');
                    const editSuggestionsContainer = document.getElementById('editColorSuggestions');
                    const editSuggestedColorsList = document.getElementById('editSuggestedColorsList');
                    
                    if (editToneSelect) {
                        editToneSelect.addEventListener('change', function() {
                            const selectedTone = this.value;
                            editSuggestedColorsList.innerHTML = '';
                            
                            if (selectedTone && colorSuggestions[selectedTone]) {
                                editSuggestionsContainer.classList.remove('d-none');
                                
                                // Display the suggested colors
                                Object.entries(colorSuggestions[selectedTone]).forEach(([colorName, colorCode]) => {
                                    const colorItem = document.createElement('div');
                                    colorItem.className = 'color-suggestion-item me-3 mb-2';
                                    colorItem.innerHTML = `
                                        <div class="d-flex align-items-center">
                                            <div style="width: 25px; height: 25px; background-color: ${colorCode}; 
                                                    border-radius: 50%; margin-right: 8px; border: 1px solid #ddd;"></div>
                                            <span>${colorName}</span>
                                        </div>
                                    `;
                                    
                                    // Make the color suggestion clickable to auto-select in the edit form
                                    colorItem.addEventListener('click', function() {
                                        // Find the color in the dropdown options
                                        const colorSelect = document.getElementById('edit_colorID');
                                        Array.from(colorSelect.options).forEach(option => {
                                            if (option.text.includes(colorName)) {
                                                colorSelect.value = option.value;
                                                // Manually trigger the change event
                                                const event = new Event('change', { bubbles: true });
                                                colorSelect.dispatchEvent(event);
                                            }
                                        });
                                    });
                                    
                                    editSuggestedColorsList.appendChild(colorItem);
                                });
                            } else {
                                editSuggestionsContainer.classList.add('d-none');
                            }
                        });
                    }

                    // Handle edit variant button clicks
                    document.querySelectorAll('.edit-variant').forEach(button => {
                        button.addEventListener('click', function() {
                            const variantId = this.getAttribute('data-variant-id');
                            fetchVariantDetails(variantId);
                        });
                    });
                    
                    // Handle delete variant button clicks
                    document.querySelectorAll('.delete-variant').forEach(button => {
                        button.addEventListener('click', function() {
                            const variantId = this.getAttribute('data-variant-id');
                            document.getElementById('deleteVariantForm').action = `/admin/products/variants/${variantId}`;
                            const deleteModal = new bootstrap.Modal(document.getElementById('deleteVariantModal'));
                            deleteModal.show();
                        });
                    });
                    
                    // Initialize tone and color selectors
                    document.querySelectorAll('.tone-select').forEach(select => {
                        select.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const container = this.closest('div').querySelector('.tone-indicator');
                            const swatch = container.querySelector('.tone-swatch');
                            const name = container.querySelector('.tone-name');
                            
                            if (this.value && selectedOption) {
                                swatch.style.backgroundColor = selectedOption.dataset.toneCode;
                                name.textContent = selectedOption.dataset.toneName;
                                container.classList.remove('d-none');
                                
                                // Update the tone suggestion dropdown to match
                                if (this.id === 'edit_toneID') {
                                    document.getElementById('editToneSuggestion').value = selectedOption.dataset.toneName;
                                    document.getElementById('editToneSuggestion').dispatchEvent(new Event('change'));
                                }
                            } else {
                                container.classList.add('d-none');
                            }
                        });
                    });
                    
                    document.querySelectorAll('.color-select').forEach(select => {
                        select.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const container = this.closest('div').querySelector('.color-indicator');
                            const swatch = container.querySelector('.color-swatch');
                            const name = container.querySelector('.color-name');
                            
                            if (this.value && selectedOption) {
                                // Set the background color of the swatch
                                swatch.style.backgroundColor = selectedOption.dataset.colorCode;
                                name.textContent = selectedOption.dataset.colorName;
                                container.classList.remove('d-none');
                            } else {
                                container.classList.add('d-none');
                            }
                        });
                    });
                });

                function fetchVariantDetails(variantId) {
                    fetch(`/admin/products/variants/${variantId}/edit`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.variant) {
                            populateEditForm(data.variant);
                            const editModal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                            editModal.show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load variant details. Please try again.');
                    });
                }

                function populateEditForm(variant) {
                    const form = document.getElementById('editVariantForm');
                    form.action = `/admin/products/variants/${variant.product_variantID}`;
                    
                    // Set values in form fields
                    document.getElementById('edit_toneID').value = variant.toneID;
                    document.getElementById('edit_colorID').value = variant.colorID;
                    document.getElementById('edit_product_size').value = variant.product_size;
                    document.getElementById('edit_product_stock').value = variant.product_stock;
                    
                    // Update image preview
                    const imageUrl = variant.product_image ? `/storage/${variant.product_image}` : '';
                    document.getElementById('current_variant_image').src = imageUrl;
                    
                    // Trigger change events to update visual indicators
                    setTimeout(() => {
                        // Create and dispatch proper change events
                        const toneEvent = new Event('change', { bubbles: true });
                        const colorEvent = new Event('change', { bubbles: true });
                        
                        toneSelect.dispatchEvent(toneEvent);
                        colorSelect.dispatchEvent(colorEvent);
                        
                        // Also update the tone suggestion dropdown
                        const selectedToneOption = toneSelect.options[toneSelect.selectedIndex];
                        if (selectedToneOption && selectedToneOption.dataset.toneName) {
                            const suggestionSelect = document.getElementById('editToneSuggestion');
                            suggestionSelect.value = selectedToneOption.dataset.toneName;
                            suggestionSelect.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }, 100); // Small delay to ensure the DOM is ready
                }
                </script>
                @endpush

                @push('styles')
                <style>
                .color-suggestion-item {
                    cursor: pointer;
                    padding: 5px 10px;
                    border-radius: 4px;
                    transition: background-color 0.2s;
                }

                .color-suggestion-item:hover {
                    background-color: #f8f9fa;
                }

                .border-left-info {
                    border-left: 4px solid #36b9cc !important;
                }

                .tone-swatch, .color-swatch {
                    width: 25px;
                    height: 25px;
                    border-radius: 50%;
                    border: 1px solid #ddd;
                }
                </style>
                @endpush
            </div>
        </main>
    </div>
</div>
@endsection
