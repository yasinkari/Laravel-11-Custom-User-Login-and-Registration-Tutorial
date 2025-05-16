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
        <!-- Basic Info Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Basic Product Information</h6>
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
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_type" class="form-label">Product Type</label>
                            <select class="form-select @error('product_type') is-invalid @enderror" 
                                   id="product_type" name="product_type" required>
                                <option value="">Select Product Type</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type }}" {{ old('product_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('product_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Base Price (RM)</label>
                            <input type="number" class="form-control @error('product_price') is-invalid @enderror" 
                                   id="product_price" name="product_price" value="{{ old('product_price') }}" 
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
                                   id="actual_price" name="actual_price" value="{{ old('actual_price') }}" 
                                   step="0.01" min="0" required>
                            <div id="discount-indicator" class="mt-1 d-none">
                                <span class="badge bg-danger">Discount: <span id="discount-percentage">0</span>% OFF</span>
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
                                <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1" checked>
                                <label class="form-check-label" for="is_visible">Product is visible to customers</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
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
        <div class="card shadow-sm mb-4" id="variantsSection" style="display: none;">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Product Variants</h6>
                <button type="button" class="btn btn-sm btn-primary" id="addVariant">
                    <i class="fas fa-plus-circle me-1"></i>Add Variant
                </button>
            </div>
            <div class="card-body">
                <!-- Color Suggestion Panel -->
                <div class="card mb-4 border-left-info">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-info mb-3">Color Suggestions by Skin Tone</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="toneSuggestion">Select Skin Tone</label>
                                    <select class="form-select" id="toneSuggestion">
                                        <option value="">Select a tone for suggestions</option>
                                        @foreach($tones as $tone)
                                            <option value="{{ $tone->tone_name }}">{{ $tone->tone_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div id="colorSuggestions" class="d-none">
                                    <label>Suggested Colors:</label>
                                    <div class="d-flex flex-wrap" id="suggestedColorsList">
                                        <!-- Suggested colors will appear here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
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
        
        <!-- Songkok Size Chart Section -->
        <div class="card shadow-sm mb-4" id="songkokSection" style="display: none;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Songkok Size Chart</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Size Chart Image</label>
                        <input type="file" class="form-control" name="size_chart_image" accept="image/*">
                        <small class="form-text text-muted">Upload an image of the Songkok size chart (optional)</small>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Available Sizes</label>
                        <div class="row">
                            @foreach(['20 3/4', '21', '21 1/4', '21 1/2', '21 3/4', '22', '22 1/4', '22 1/2', '22 3/4', '23', '23 1/4', '23 1/2', '23 3/4'] as $size)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="songkok_sizes[]" value="{{ $size }}" id="size_{{ str_replace(' ', '_', $size) }}">
                                        <label class="form-check-label" for="size_{{ str_replace(' ', '_', $size) }}">'{{ $size }}"'</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Stock Quantities</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody id="songkokStockTable">
                                        <!-- Stock inputs will be added here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
        
        <!-- Submit Button for Non-Variant Products -->
        <div id="nonVariantSubmit" class="text-end mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Save Product
            </button>
        </div>
    </form>
</div>

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

@push('styles')
<style>
.variants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('variantsContainer');
    const template = document.getElementById('variantTemplate');
    const productTypeSelect = document.getElementById('product_type');
    const variantsSection = document.getElementById('variantsSection');
    const songkokSection = document.getElementById('songkokSection');
    const nonVariantSubmit = document.getElementById('nonVariantSubmit');
    let variantCount = 0;

    // Color suggestions data from backend
    const colorSuggestions = @json($colorSuggestions);
    
    // Setup tone suggestion dropdown
    const toneSelect = document.getElementById('toneSuggestion');
    const suggestionsContainer = document.getElementById('colorSuggestions');
    const suggestedColorsList = document.getElementById('suggestedColorsList');
    
    // Handle product type change
    productTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all sections first
        variantsSection.style.display = 'none';
        songkokSection.style.display = 'none';
        nonVariantSubmit.style.display = 'block';
        
        // Show appropriate section based on product type
        if (selectedType === 'Baju Melayu' || selectedType === 'Kurta') {
            variantsSection.style.display = 'block';
            nonVariantSubmit.style.display = 'none';
        } else if (selectedType === 'Songkok') {
            songkokSection.style.display = 'block';
            nonVariantSubmit.style.display = 'none';
            updateSongkokSizesTable();
        }
    });
    
    // Initialize based on any pre-selected value (for form validation failures)
    if (productTypeSelect.value) {
        productTypeSelect.dispatchEvent(new Event('change'));
    }
    
    // Handle Songkok size checkboxes
    const songkokSizeCheckboxes = document.querySelectorAll('input[name="songkok_sizes[]"]');
    songkokSizeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSongkokSizesTable);
    });
    
    // Function to update the Songkok sizes stock table
    function updateSongkokSizesTable() {
        const stockTable = document.getElementById('songkokStockTable');
        stockTable.innerHTML = '';
        
        document.querySelectorAll('input[name="songkok_sizes[]"]:checked').forEach(checkbox => {
            const size = checkbox.value;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>'${size}"'</td>
                <td>
                    <input type="number" class="form-control" name="songkok_stock[${size}]" min="0" value="0" required>
                </td>
            `;
            stockTable.appendChild(row);
        });
    }
    
    // Add variant button functionality
    const addVariantBtn = document.getElementById('addVariant');
    addVariantBtn.addEventListener('click', function() {
        addVariant();
    });
    
    // Function to add a new variant
    function addVariant() {
        const variantNode = template.content.cloneNode(true);
        const variantElement = variantNode.querySelector('.variant-item');
        
        // Update variant number and index
        variantElement.querySelector('.variant-number').textContent = variantCount + 1;
        
        // Update all name attributes with the correct index
        variantElement.querySelectorAll('[name*="__index__"]').forEach(el => {
            el.name = el.name.replace('__index__', variantCount);
        });
        
        // Add remove button functionality
        variantElement.querySelector('.remove-variant').addEventListener('click', function() {
            variantElement.remove();
        });
        
        // Add the variant to the container
        container.appendChild(variantElement);
        variantCount++;
    }
    
    // Add at least one variant if the variants section is visible
    if (variantsSection.style.display !== 'none') {
        addVariant();
    }
    
    // Tone suggestion handling
    toneSelect.addEventListener('change', function() {
        const selectedTone = this.value;
        suggestedColorsList.innerHTML = '';
        
        if (selectedTone && colorSuggestions[selectedTone]) {
            suggestionsContainer.classList.remove('d-none');
            
            // Display the suggested colors
            Object.entries(colorSuggestions[selectedTone]).forEach(([colorName, colorCode]) => {
                const colorItem = document.createElement('div');
                colorItem.className = 'color-suggestion-item me-3 mb-2';
                colorItem.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="color-swatch" style="width: 25px; height: 25px; background-color: ${colorCode}; 
                                border-radius: 50%; margin-right: 8px; border: 1px solid #ddd;"></div>
                        <span>${colorName}</span>
                    </div>
                `;
                
                suggestedColorsList.appendChild(colorItem);
            });
        } else {
            suggestionsContainer.classList.add('d-none');
        }
    });
    
    // Calculate discount percentage when prices change
    const basePrice = document.getElementById('product_price');
    const actualPrice = document.getElementById('actual_price');
    const discountIndicator = document.getElementById('discount-indicator');
    const discountPercentage = document.getElementById('discount-percentage');
    
    function updateDiscount() {
        const basePriceValue = parseFloat(basePrice.value) || 0;
        const actualPriceValue = parseFloat(actualPrice.value) || 0;
        
        if (basePriceValue > 0 && actualPriceValue > 0 && basePriceValue > actualPriceValue) {
            const discount = Math.round(((basePriceValue - actualPriceValue) / basePriceValue) * 100);
            discountPercentage.textContent = discount;
            discountIndicator.classList.remove('d-none');
        } else {
            discountIndicator.classList.add('d-none');
        }
    }
    
    basePrice.addEventListener('input', updateDiscount);
    actualPrice.addEventListener('input', updateDiscount);
    
    // Initial update
    updateDiscount();
});
</script>
@endpush
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the elements
        const productTypeSelect = document.getElementById('product_type');
        const variantsSection = document.getElementById('variantsSection');
        const nonVariantSubmit = document.getElementById('nonVariantSubmit');
        
        // Function to check if variants should be shown
        function checkVariantsVisibility() {
            const selectedType = productTypeSelect.value;
            
            // Only show variants for "Baju Melayu"
            if (selectedType === 'Baju Melayu') {
                variantsSection.style.display = 'block';
                nonVariantSubmit.style.display = 'none';
            } else {
                variantsSection.style.display = 'none';
                nonVariantSubmit.style.display = 'block';
            }
        }
        
        // Check visibility on page load (for when form reloads with validation errors)
        checkVariantsVisibility();
        
        // Add event listener for product type changes
        productTypeSelect.addEventListener('change', checkVariantsVisibility);
    });
</script>
@endsection
