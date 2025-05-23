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
        border-radius: 0;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        background: white;
        padding: 20px;
        margin-bottom: 30px;
        position: relative;
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
    
    /* Zoom icon overlay */
    .product-image:after {
        content: '\f00e';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(15, 44, 31, 0.7);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .product-image:hover:after {
        opacity: 1;
    }

    /* Enhanced Product Info Section */
    .product-info {
        padding: 40px;
        background: white;
        border-radius: 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #0f2c1f;
        margin-bottom: 20px;
        line-height: 1.2;
        position: relative;
        padding-bottom: 15px;
    }
    
    .product-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #0f2c1f, #2a5a4a);
    }

    .stock-status {
        display: inline-block;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 0;
        margin-bottom: 20px;
    }
    
    .stock-status.in-stock {
        background-color: rgba(15, 44, 31, 0.1);
        color: #0f2c1f;
        border: 1px solid rgba(15, 44, 31, 0.2);
    }
    
    .stock-status.out-of-stock {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }
    
    .product-price {
        font-size: 28px;
        font-weight: 700;
        color: #0f2c1f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 20px;
    }
    
    .new-price {
        color: #0f2c1f !important;
        font-weight: 700 !important;
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
        border-radius: 0;
        margin-top: 30px;
        border: 1px solid rgba(15, 44, 31, 0.1);
    }

    .variant-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f2c1f;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        padding-bottom: 10px;
    }
    
    .variant-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: #0f2c1f;
    }

    /* Enhanced Tone Selector */
    .tone-selector {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        margin-bottom: 35px;
        padding: 25px;
        background: white;
        border-radius: 0;
        position: relative;
        max-height: 120px;
        scrollbar-width: thin;
        scrollbar-color: #0f2c1f #f0f0f0;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .tone-selector::-webkit-scrollbar {
        height: 6px;
    }

    .tone-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 0;
    }

    .tone-selector::-webkit-scrollbar-thumb {
        background: #0f2c1f;
        border-radius: 0;
    }

    .tone-option {
        min-width: 50px;
        height: 50px;
        border-radius: 0;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .tone-option:hover {
        transform: scale(1.1);
        z-index: 1;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .tone-option.active {
        border-color: #0f2c1f;
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(15, 44, 31, 0.3);
    }

    .tone-option .tone-name {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 12px;
        background: rgba(15, 44, 31, 0.9);
        color: white;
        padding: 3px 8px;
        border-radius: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
        font-weight: 500;
    }

    .tone-option:hover .tone-name {
        opacity: 1;
    }

    /* Enhanced Color Selector */
    .color-selector {
        display: none;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        padding: 25px;
        background: white;
        border-radius: 0;
        margin-top: 30px;
        max-height: 120px;
        scrollbar-width: thin;
        scrollbar-color: #0f2c1f #f0f0f0;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .color-selector::-webkit-scrollbar {
        height: 6px;
    }

    .color-selector::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 0;
    }

    .color-selector::-webkit-scrollbar-thumb {
        background: #0f2c1f;
        border-radius: 0;
    }

    .color-option {
        min-width: 50px;
        height: 50px;
        border-radius: 0;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .color-option:hover {
        transform: scale(1.1);
        z-index: 1;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .color-option.active {
        border-color: #0f2c1f;
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(15, 44, 31, 0.3);
    }

    .color-option .color-name {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 12px;
        background: rgba(15, 44, 31, 0.9);
        color: white;
        padding: 3px 8px;
        border-radius: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
        z-index: 2;
        font-weight: 500;
    }

    .color-option:hover .color-name {
        opacity: 1;
    }
    
    /* Enhanced Variant Table */
    .variants-table {
        margin-top: 30px;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 0;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        background-color: rgba(15, 44, 31, 0.05);
        color: #0f2c1f;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        padding: 15px;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table tr:hover {
        background-color: rgba(15, 44, 31, 0.02);
    }
    
    /* Enhanced Quantity Input */
    .quantity-input {
        width: 70px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 0;
        font-size: 14px;
    }
    
    /* Enhanced Checkbox */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #0f2c1f;
    }
    
    /* Enhanced Add to Cart Button */
    .btn-add-to-cart {
        background-color: #0f2c1f;
        color: #fff;
        border: none;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 30px;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-add-to-cart:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: all 0.5s ease;
    }
    
    .btn-add-to-cart:hover {
        background-color: #143c2a;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }
    
    .btn-add-to-cart:active {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-add-to-cart:hover:before {
        left: 100%;
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
                    
                    <!-- Inside the product info section, update the price display -->
                    <div class="stock-status {{ $hasStock ? 'in-stock' : 'out-of-stock' }}">
                        <i class="fas {{ $hasStock ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $hasStock ? 'In Stock' : 'Out of Stock' }}
                    </div>
                    
                    @php
                        $product = $data['product'];
                        $hasPromotion = false;
                        $discountedPrice = $product['product_price'];
                        
                        // Check if there's an active promotion
                        if (isset($product['promotions']) && count($product['promotions']) > 0) {
                            foreach ($product['promotions'] as $promo) {
                                if ($promo['is_active'] && 
                                    strtotime($promo['start_date']) <= time() && 
                                    (is_null($promo['end_date']) || strtotime($promo['end_date']) >= time())) {
                                    
                                    $hasPromotion = true;
                                    
                                    if ($promo['promotion_type'] == 'percentage') {
                                        $discountedPrice = $product['product_price'] * (1 - ($promo['discount_amount'] / 100));
                                    } elseif ($promo['promotion_type'] == 'fixed') {
                                        $discountedPrice = $product['product_price'] - $promo['discount_amount'];
                                    }
                                    
                                    // Ensure price doesn't go below zero
                                    $discountedPrice = max(0, $discountedPrice);
                                    $promotionName = $promo['promotion_name'];
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($hasPromotion)
                        <div class="promotion-badge mb-2">
                            <span class="badge bg-danger">{{ $promotionName }}</span>
                        </div>
                        <p class="product-price">
                            <span class="original-price text-muted text-decoration-line-through">
                                RM {{ number_format($product['product_price'], 2) }}
                            </span>
                            <span class="new-price">
                                RM {{ number_format($discountedPrice, 2) }}
                            </span>
                        </p>
                    @else
                        <p class="product-price">RM {{ number_format($product['product_price'], 2) }}</p>
                    @endif
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
                                    <div class="size-quantity-section p-4 bg-white rounded-3 shadow-sm">
                                        <h3 class="section-title mb-4 pb-2 border-bottom">Select Size and Quantity</h3>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="py-3">Size</th>
                                                        <th class="py-3">Stock Status</th>
                                                        <th class="py-3">Select</th>
                                                        <th class="py-3">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="border-top-0">
                                                    <!-- Variants will be populated dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn-add-to-cart w-100 mt-4 py-3 rounded-3 text-white fw-bold">Add to Cart</button>
                                    </div>
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