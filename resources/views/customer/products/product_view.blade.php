@extends('layout.layout')

@section('css')
<style>
    .product-details {
        padding: 60px 0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        min-height: 100vh;
    }

    /* Enhanced Product Image Section */
    .product-image {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        background: white;
        padding: 20px;
        margin-bottom: 30px;
    }

    .product-image img {
        width: 100%;
        height: 500px;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-image:hover img {
        transform: scale(1.02);
    }

    /* Enhanced Product Info Section */
    .product-info {
        padding: 40px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .product-price {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-price::before {
        content: "Price";
        font-size: 14px;
        color: #95a5a6;
        font-weight: 500;
    }

    .product-description {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.8;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #ecf0f1;
    }

    /* Enhanced Variant Section */
    .variant-section {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 15px;
        margin-top: 30px;
    }

    .variant-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .variant-title::after {
        content: "Select options below";
        font-size: 13px;
        color: #e74c3c;
        font-weight: 500;
        animation: pulse 2s infinite;
    }

    /* Enhanced Tone Selector */
    .tone-selector {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
        gap: 10px;
        margin-bottom: 35px;
        padding: 20px;
        background: white;
        border-radius: 15px;
        position: relative;
        max-height: 180px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e74c3c #f0f0f0;
    }

    .tone-selector::-webkit-scrollbar {
        width: 6px;
    }

    .tone-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .tone-selector::-webkit-scrollbar-thumb {
        background: #e74c3c;
        border-radius: 10px;
    }

    .tone-option {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .tone-option:hover {
        transform: scale(1.1);
        z-index: 1;
    }

    .tone-option.active {
        border-color: #e74c3c;
        transform: scale(1.1);
    }

    .tone-option .tone-name {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 11px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
    }

    .tone-option:hover .tone-name {
        opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .tone-selector, .color-selector {
            grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
            gap: 8px;
            padding: 15px;
            max-height: 150px;
        }

        .tone-option, .color-option {
            width: 40px;
            height: 40px;
        }

        .tone-option .tone-name,
        .color-option .color-name {
            font-size: 10px;
            padding: 1px 4px;
        }
    }

    @media (max-width: 480px) {
        .tone-selector, .color-selector {
            grid-template-columns: repeat(auto-fill, minmax(35px, 1fr));
            gap: 6px;
            padding: 12px;
            max-height: 120px;
        }

        .tone-option, .color-option {
            width: 35px;
            height: 35px;
        }
    }

    .color-selector {
        display: none;
        grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
        gap: 10px;
        padding: 20px;
        background: white;
        border-radius: 15px;
        margin-top: 30px;
        max-height: 200px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #ff3366 #f0f0f0;
    }

    .color-selector::-webkit-scrollbar {
        width: 6px;
    }

    .color-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .color-selector::-webkit-scrollbar-thumb {
        background: #ff3366;
        border-radius: 10px;
    }

    .color-option {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .color-option:hover {
        transform: scale(1.1);
        z-index: 1;
    }

    .color-option.active {
        border-color: #ff3366;
        transform: scale(1.1);
    }

    .color-option .color-name {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 11px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
    }

    .color-option:hover .color-name {
        opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-image img {
            height: 300px;
        }

        .product-info {
            padding: 20px;
        }

        .variant-section {
            padding: 15px;
        }

        .tone-selector {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 15px;
            padding: 15px;
        }

        .color-selector {
            grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
            gap: 8px;
            padding: 15px;
            max-height: 150px;
        }

        .color-option {
            width: 40px;
            height: 40px;
        }

        .table th, .table td {
            padding: 10px;
            font-size: 14px;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
        }
    }

    @media (max-width: 480px) {
        .product-image img {
            height: 250px;
        }

        .product-title {
            font-size: 24px;
        }

        .product-price {
            font-size: 22px;
        }

        .variant-title {
            font-size: 16px;
        }

        .color-selector {
            grid-template-columns: repeat(auto-fill, minmax(35px, 1fr));
            gap: 6px;
        }

        .color-option {
            width: 35px;
            height: 35px;
        }
    }
</style>
@endsection

@section('content')
<div class="product-details">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image">
                    <img id="product-image" src="{{ !empty($data['tones']) && !empty($data['tones'][0]['colors']) && !empty($data['tones'][0]['colors'][0]['sizes']) 
                        ? asset('storage/' . $data['tones'][0]['colors'][0]['sizes'][0]['product_image']) 
                        : asset('image/IMG_7282.jpg') }}" 
                        alt="{{ $data['product']['product_name'] }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $data['product']['product_name'] }}</h1>
                    
                    @php
                        $hasStock = false;
                        foreach ($data['tones'] as $tone) {
                            foreach ($tone['colors'] as $color) {
                                foreach ($color['sizes'] as $size) {
                                    if ($size['product_stock'] > 0) {
                                        $hasStock = true;
                                        break 3;
                                    }
                                }
                            }
                        }
                    @endphp
                    
                    <div class="stock-status {{ $hasStock ? 'in-stock' : 'out-of-stock' }}">
                        {{ $hasStock ? 'In Stock' : 'Out of Stock' }}
                    </div>
                    
                    <p class="product-price">RM {{ number_format($data['product']['product_price'], 2) }}</p>
                    <p class="product-description">{{ $data['product']['product_description'] }}</p>

                    @if(count($data['tones']) > 0)
                        <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $data['product']['productID'] }}">
                            
                            <div class="variant-section">
                                <h3 class="variant-title">Select Skin Tone</h3>
                                <div class="tone-selector">
                                    @foreach($data['tones'] as $tone)
                                        <div class="tone-option" 
                                             data-tone-id="{{ $tone['tone_id'] }}"
                                             style="background-color: {{ $tone['tone_code'] }}">
                                            <span class="tone-name">{{ $tone['tone_name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="color-selector">
                                    <h3 class="variant-title">Select Color</h3>
                                    <!-- Colors will be populated dynamically -->
                                </div>

                                <div class="variants-table">
                                    <h3 class="variant-title">Select Size and Quantity</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Stock</th>
                                                <th>Select</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Variants will be populated dynamically -->
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productData = @json($data);
    let selectedTone = null;
    let selectedColor = null;

    // Handle tone selection
    document.querySelectorAll('.tone-option').forEach(toneOption => {
        toneOption.addEventListener('click', function() {
            const toneId = parseInt(this.dataset.toneId);
            
            // Update UI
            document.querySelectorAll('.tone-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Reset color selection
            selectedColor = null;
            selectedTone = toneId;
            
            // Find the selected tone data
            const selectedToneData = productData.tones.find(tone => tone.tone_id === toneId);
            
            // Display colors for selected tone
            const colorSelector = document.querySelector('.color-selector');
            colorSelector.innerHTML = '<h3 class="variant-title">Select Color</h3>';
            colorSelector.style.display = 'flex';
            
            selectedToneData.colors.forEach(color => {
                const colorOption = document.createElement('div');
                colorOption.className = 'color-option';
                colorOption.dataset.colorId = color.color_id;
                colorOption.style.backgroundColor = color.color_code;
                colorOption.innerHTML = `<span class="color-name">${color.color_name}</span>`;
                colorOption.addEventListener('click', () => selectColor(color.color_id, selectedToneData));
                colorSelector.appendChild(colorOption);
            });
            
            // Hide variants table
            document.querySelector('.variants-table').style.display = 'none';
        });
    });

    function selectColor(colorId, toneData) {
        selectedColor = colorId;
        
        // Update UI
        document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
        document.querySelector(`[data-color-id="${colorId}"]`).classList.add('active');
        
        // Find the selected color data
        const selectedColorData = toneData.colors.find(color => color.color_id === colorId);
        
        // Update product image if first size has an image
        if (selectedColorData.sizes.length > 0) {
            document.getElementById('product-image').src = '/storage/' + selectedColorData.sizes[0].product_image;
        }
        
        // Populate variants table
        const tableBody = document.querySelector('.variants-table tbody');
        tableBody.innerHTML = '';
        
        selectedColorData.sizes.forEach(size => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${size.size_name}</td>
                <td>${size.product_stock}</td>
                <td>
                    <input type="checkbox" name="variants[]" value="${size.product_variantID}"
                           ${size.product_stock <= 0 ? 'disabled' : ''}>
                </td>
                <td>
                    <input type="number" class="quantity-input" name="quantities[${size.product_variantID}]"
                           min="1" max="${size.product_stock}" value="1" disabled>
                </td>
            `;
            tableBody.appendChild(row);
        });
        
        // Show variants table
        document.querySelector('.variants-table').style.display = 'block';
        
        // Handle checkbox and quantity input interaction
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const quantityInput = this.closest('tr').querySelector('.quantity-input');
                quantityInput.disabled = !this.checked;
                if (this.checked) {
                    quantityInput.value = 1;
                } else {
                    quantityInput.value = 0;
                }
            });
        });
    }
});
</script>
@endpush