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
        <div class="card shadow-sm mb-4">
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
    let variantCount = 0;

    // Color suggestions data from backend
    const colorSuggestions = @json($colorSuggestions);
    
    // Setup tone suggestion dropdown
    const toneSelect = document.getElementById('toneSuggestion');
    const suggestionsContainer = document.getElementById('colorSuggestions');
    const suggestedColorsList = document.getElementById('suggestedColorsList');
    
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
                
                // Make the color suggestion clickable to auto-select in new variants
                colorItem.addEventListener('click', function() {
                    // Find the color in the dropdown options
                    const colorOptions = document.querySelectorAll('.variant-item select[name$="[colorID]"]');
                    colorOptions.forEach(select => {
                        Array.from(select.options).forEach(option => {
                            if (option.text.includes(colorName)) {
                                select.value = option.value;
                            }
                        });
                    });
                });
                
                suggestedColorsList.appendChild(colorItem);
            });
        } else {
            suggestionsContainer.classList.add('d-none');
        }
    });

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
        
        // Add tone change listener to update color suggestions
        const toneSelect = variantDiv.querySelector('select[name$="[toneID]"]');
        const colorSelect = variantDiv.querySelector('select[name$="[colorID]"]');
        
        toneSelect.addEventListener('change', function() {
            // Get the tone name from the selected option text
            const selectedToneText = this.options[this.selectedIndex].text;
            
            // Update the suggestion dropdown to match
            document.getElementById('toneSuggestion').value = selectedToneText;
            document.getElementById('toneSuggestion').dispatchEvent(new Event('change'));
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
    
    // Add at least one variant by default
    addVariant();
    
    // Calculate discount percentage
    const basePrice = document.getElementById('product_price');
    const actualPrice = document.getElementById('actual_price');
    const discountIndicator = document.getElementById('discount-indicator');
    const discountPercentage = document.getElementById('discount-percentage');
    
    function calculateDiscount() {
        if (basePrice.value && actualPrice.value && parseFloat(basePrice.value) > 0 && parseFloat(actualPrice.value) > 0) {
            if (parseFloat(actualPrice.value) < parseFloat(basePrice.value)) {
                const discount = ((parseFloat(basePrice.value) - parseFloat(actualPrice.value)) / parseFloat(basePrice.value)) * 100;
                discountPercentage.textContent = Math.round(discount);
                discountIndicator.classList.remove('d-none');
            } else {
                discountIndicator.classList.add('d-none');
            }
        } else {
            discountIndicator.classList.add('d-none');
        }
    }
    
    basePrice.addEventListener('input', calculateDiscount);
    actualPrice.addEventListener('input', calculateDiscount);
    
    // Initial calculation
    calculateDiscount();
});
</script>
@endpush
@endsection
