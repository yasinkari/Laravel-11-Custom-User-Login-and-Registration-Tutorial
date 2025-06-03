@extends("layout.layout")
@section("css")
<style>
    /* Professional styling based on the JAKEL reference */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fff;
        color: #333;
    }
    
    .product-detail-section {
        padding: 40px 0;
    }
    
    .breadcrumb-container {
        margin-bottom: 30px;
        font-size: 14px;
    }
    
    .breadcrumb-container a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .breadcrumb-container a:hover {
        color: #000;
    }
    
    .breadcrumb-container span {
        margin: 0 8px;
        color: #999;
    }
    
    .product-image-container {
        position: relative;
        border: 1px solid #eee;
        padding: 10px;
        margin-bottom: 20px;
    }
    
    .product-main-image {
        width: 100%;
        height: auto;
        margin-bottom: 15px;
    }
    
    .product-thumbnails {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .product-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 1px solid #ddd;
        transition: border-color 0.3s;
    }
    
    .product-thumbnail:hover, .product-thumbnail.active {
        border-color: #000;
    }
    
    .product-info h1 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .product-code {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }
    
    .product-price-container {
        margin-bottom: 20px;
    }
    
    .product-price {
        font-size: 20px;
        font-weight: 600;
        color: #000;
    }
    
    .product-original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 16px;
        margin-right: 10px;
    }
    
    .product-discount {
        background-color: #d9534f;
        color: white;
        padding: 3px 8px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 2px;
    }
    
    .product-description {
        margin: 20px 0;
        font-size: 14px;
        line-height: 1.6;
        color: #666;
    }
    
    .product-options {
        margin-bottom: 30px;
    }
    
    .option-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    
    .size-options {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .size-option {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .size-option:hover, .size-option.active {
        border-color: #000;
        background-color: #000;
        color: #fff;
    }
    
    .color-options {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        transition: transform 0.3s;
        border: 1px solid #ddd;
    }
    
    .color-option:hover, .color-option.active {
        transform: scale(1.1);
        box-shadow: 0 0 0 2px #fff, 0 0 0 3px #000;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .quantity-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        font-size: 16px;
        cursor: pointer;
    }
    
    .quantity-input {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 5px;
    }
    
    .add-to-cart-btn {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 12px 30px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .add-to-cart-btn:hover {
        background-color: #333;
    }
    
    /* .wishlist-btn {
        background-color: #fff;
        color: #000;
        border: 1px solid #000;
        padding: 12px 30px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    } */
    
    /* .wishlist-btn i {
        margin-right: 8px;
    }
    
    .wishlist-btn:hover {
        background-color: #f5f5f5;
    } */
    
    .product-meta {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .meta-item {
        display: flex;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .meta-label {
        width: 100px;
        color: #666;
    }
    
    .meta-value {
        color: #000;
    }
    
    .related-products {
        margin-top: 60px;
    }
    
    .related-products h2 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .product-card {
        border: none;
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-card .card-body {
        padding: 15px 10px;
    }
    
    .product-card .card-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
    }
    
    .product-card .price {
        font-weight: 600;
        color: #000;
        margin-bottom: 15px;
        display: block;
    }
    
    .product-card .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 8px;
    }
    
    .product-card .discount {
        color: #d9534f;
        font-size: 14px;
    }
    
    .btn-view-details {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 8px 15px;
        font-size: 12px;
        text-transform: uppercase;
        transition: background-color 0.3s;
    }
    
    .btn-view-details:hover {
        background-color: #333;
        color: #fff;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section("content")
<div class="product-detail-section">
    <div class="container">
        <div class="breadcrumb-container">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ route('products.customer') }}">Products</a>
            <span>/</span>
            <a href="#" class="active">Product Details</a>
        </div>
        
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                <div class="product-image-container">
                    @if(isset($data['tones'][0]['colors'][0]['sizes'][0]['product_image']))
                        <img src="{{ asset('storage/' . $data['tones'][0]['colors'][0]['sizes'][0]['product_image']) }}" class="product-main-image" alt="{{ $data['product']['product_name'] }}">
                        
                        <div class="product-thumbnails">
                            @foreach($data['tones'] as $toneIndex => $tone)
                                @foreach($tone['colors'] as $colorIndex => $color)
                                    @if(isset($color['sizes'][0]['product_image']))
                                        <img src="{{ asset('storage/' . $color['sizes'][0]['product_image']) }}" 
                                            class="product-thumbnail {{ $toneIndex == 0 && $colorIndex == 0 ? 'active' : '' }}" 
                                            data-tone="{{ $tone['tone_id'] }}" 
                                            data-color="{{ $color['color_id'] }}"
                                            alt="Thumbnail">
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <img src="{{ asset('image/placeholder.jpg') }}" class="product-main-image" alt="Product Image">
                    @endif
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="col-md-6">
                <div class="product-info">
                    <h1>{{ $data['product']['product_name'] }}</h1>
                    <div class="product-code">SKU: BM-{{ $data['product']['productID'] }}</div>
                    
                    <div class="product-price-container">
                        <div class="d-flex align-items-center">
                            <span class="product-original-price">RM{{ number_format($data['product']['actual_price'], 2) }}</span>
                            <span class="product-price">RM{{ number_format($data['product']['product_price'], 2) }}</span>
                            @php
                                $discount = round((($data['product']['actual_price'] - $data['product']['product_price']) / $data['product']['actual_price']) * 100);
                            @endphp
                            <span class="product-discount ms-2">{{ $discount }}% OFF</span>
                        </div>
                    </div>
                    
                    <div class="product-description">
                        {{ $data['product']['product_description'] }}
                    </div>
                    
                    <div class="product-options">
                        <!-- Tone Selection -->
                        <label class="option-label">Tone</label>
                        <div class="tone-options size-options">
                            @foreach($data['tones'] as $index => $tone)
                                <div class="size-option tone-option {{ $index == 0 ? 'active' : '' }}" 
                                    data-tone-id="{{ $tone['tone_id'] }}">
                                    {{ $tone['tone_name'] }}
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Color Selection - Will be populated by JS -->
                        <label class="option-label">Color</label>
                        <div class="color-options" id="color-options-container">
                            @if(isset($data['tones'][0]['colors']))
                                @foreach($data['tones'][0]['colors'] as $index => $color)
                                    <div class="color-option {{ $index == 0 ? 'active' : '' }}" 
                                        data-color-id="{{ $color['color_id'] }}" 
                                        style="background-color: {{ $color['color_code'] }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Size Selection - Will be populated by JS -->
                        <label class="option-label">Size</label>
                        <div class="size-options" id="size-options-container">
                            @if(isset($data['tones'][0]['colors'][0]['sizes']))
                                @foreach($data['tones'][0]['colors'][0]['sizes'] as $index => $size)
                                    <div class="size-option {{ $index == 0 ? 'active' : '' }}" 
                                        data-size="{{ $size['product_size'] }}" 
                                        data-variant-id="{{ $size['product_variantID'] }}"
                                        data-stock="{{ $size['product_stock'] }}">
                                        {{ $size['product_size'] }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <div class="quantity-selector">
                        <button class="quantity-btn decrease">-</button>
                        <input type="number" class="quantity-input" value="1" min="1" max="10">
                        <button class="quantity-btn increase">+</button>
                    </div>
                    
                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $data['product']['productID'] }}">
                        <input type="hidden" name="variant_id" id="variant-id" value="{{ isset($data['tones'][0]['colors'][0]['sizes'][0]['product_variantID']) ? $data['tones'][0]['colors'][0]['sizes'][0]['product_variantID'] : '' }}">
                        <input type="hidden" name="quantity" id="quantity-value" value="1">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                    {{-- <button class="wishlist-btn"><i class="far fa-heart"></i> Add to Wishlist</button> --}}
                    
                    <div class="product-meta">
                        <div class="meta-item">
                            <div class="meta-label">Category:</div>
                            <div class="meta-value">Baju Melayu</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Material:</div>
                            <div class="meta-value">Premium Cotton</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Availability:</div>
                            <div class="meta-value" id="stock-status">
                                @if(isset($data['tones'][0]['colors'][0]['sizes'][0]['product_stock']) && $data['tones'][0]['colors'][0]['sizes'][0]['product_stock'] > 0)
                                    In Stock ({{ $data['tones'][0]['colors'][0]['sizes'][0]['product_stock'] }} available)
                                @else
                                    Out of Stock
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="related-products">
            <h2>You May Also Like</h2>
            <div class="row">
                @foreach($data['tones'] as $tone)
                    @foreach($tone['colors'] as $color)
                        @if(isset($color['sizes'][0]))
                            <div class="col-md-3 mb-4">
                                <div class="card product-card">
                                    <img src="{{ asset('storage/' . $color['sizes'][0]['product_image']) }}" class="card-img-top" alt="Related Product">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $data['product']['product_name'] }} - {{ $color['color_name'] }}</h5>
                                        <div class="d-flex justify-content-center align-items-center mb-2">
                                            <span class="original-price">RM{{ number_format($data['product']['actual_price'], 2) }}</span>
                                            <span class="price ms-2">RM{{ number_format($data['product']['product_price'], 2) }}</span>
                                            <span class="discount ms-2">{{ $discount }}% OFF</span>
                                        </div>
                                        <a href="{{ route('products.view', $data['product']['productID']) }}" class="btn btn-view-details">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store all product data
    const productData = @json($data);
    
    // Elements
    const mainImage = document.querySelector('.product-main-image');
    const thumbnails = document.querySelectorAll('.product-thumbnail');
    const toneOptions = document.querySelectorAll('.tone-option');
    const colorOptionsContainer = document.getElementById('color-options-container');
    const sizeOptionsContainer = document.getElementById('size-options-container');
    const quantityInput = document.querySelector('.quantity-input');
    const quantityValue = document.getElementById('quantity-value');
    const variantIdInput = document.getElementById('variant-id');
    const stockStatus = document.getElementById('stock-status');
    const addToCartForm = document.getElementById('add-to-cart-form');
    
    // Current selections
    let currentToneId = toneOptions.length > 0 ? toneOptions[0].dataset.toneId : null;
    let currentColorId = null;
    let currentSize = null;
    let currentVariantId = null;
    
    // Initialize with first tone's first color and size
    if (productData.tones.length > 0) {
        const firstTone = productData.tones[0];
        currentToneId = firstTone.tone_id;
        
        if (firstTone.colors.length > 0) {
            const firstColor = firstTone.colors[0];
            currentColorId = firstColor.color_id;
            
            if (firstColor.sizes.length > 0) {
                const firstSize = firstColor.sizes[0];
                currentSize = firstSize.product_size;
                currentVariantId = firstSize.product_variantID;
                
                // Set initial variant ID
                if (variantIdInput) {
                    variantIdInput.value = currentVariantId;
                }
            }
        }
    }
    
    // Thumbnail click handler
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Update active thumbnail
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Update main image
            mainImage.src = this.src;
            
            // Update selections based on thumbnail data
            const toneId = this.dataset.tone;
            const colorId = this.dataset.color;
            
            if (toneId && colorId) {
                // Find and activate the corresponding tone option
                toneOptions.forEach(option => {
                    if (option.dataset.toneId === toneId) {
                        option.click();
                    }
                });
                
                // Find and activate the corresponding color option
                setTimeout(() => {
                    const colorOptions = document.querySelectorAll('.color-option');
                    colorOptions.forEach(option => {
                        if (option.dataset.colorId === colorId) {
                            option.click();
                        }
                    });
                }, 100);
            }
        });
    });
    
    // Tone selection
    toneOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Update active tone
            toneOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            
            // Get selected tone ID
            currentToneId = this.dataset.toneId;
            
            // Find the tone in data
            const selectedTone = productData.tones.find(tone => tone.tone_id == currentToneId);
            
            if (selectedTone && selectedTone.colors.length > 0) {
                // Update color options
                updateColorOptions(selectedTone.colors);
                
                // Select first color by default
                currentColorId = selectedTone.colors[0].color_id;
                
                // Update size options based on first color
                if (selectedTone.colors[0].sizes.length > 0) {
                    updateSizeOptions(selectedTone.colors[0].sizes);
                    
                    // Select first size by default
                    if (selectedTone.colors[0].sizes.length > 0) {
                        currentSize = selectedTone.colors[0].sizes[0].product_size;
                        currentVariantId = selectedTone.colors[0].sizes[0].product_variantID;
                        
                        // Update variant ID
                        if (variantIdInput) {
                            variantIdInput.value = currentVariantId;
                        }
                        
                        // Update stock status
                        updateStockStatus(selectedTone.colors[0].sizes[0].product_stock);
                        
                        // Update main image
                        if (selectedTone.colors[0].sizes[0].product_image) {
                            mainImage.src = `/storage/${selectedTone.colors[0].sizes[0].product_image}`;
                        }
                    }
                }
            }
        });
    });
    
    // Function to update color options
    function updateColorOptions(colors) {
        // Clear current options
        colorOptionsContainer.innerHTML = '';
        
        // Add new color options
        colors.forEach((color, index) => {
            const colorOption = document.createElement('div');
            colorOption.className = `color-option ${index === 0 ? 'active' : ''}`;
            colorOption.dataset.colorId = color.color_id;
            colorOption.style.backgroundColor = color.color_code;
            
            colorOption.addEventListener('click', function() {
                // Update active color
                document.querySelectorAll('.color-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');
                
                // Get selected color ID
                currentColorId = this.dataset.colorId;
                
                // Find the tone and color in data
                const selectedTone = productData.tones.find(tone => tone.tone_id == currentToneId);
                if (selectedTone) {
                    const selectedColor = selectedTone.colors.find(color => color.color_id == currentColorId);
                    if (selectedColor && selectedColor.sizes.length > 0) {
                        // Update size options
                        updateSizeOptions(selectedColor.sizes);
                        
                        // Select first size by default
                        currentSize = selectedColor.sizes[0].product_size;
                        currentVariantId = selectedColor.sizes[0].product_variantID;
                        
                        // Update variant ID
                        if (variantIdInput) {
                            variantIdInput.value = currentVariantId;
                        }
                        
                        // Update stock status
                        updateStockStatus(selectedColor.sizes[0].product_stock);
                        
                        // Update main image
                        if (selectedColor.sizes[0].product_image) {
                            mainImage.src = `/storage/${selectedColor.sizes[0].product_image}`;
                        }
                    }
                }
            });
            
            colorOptionsContainer.appendChild(colorOption);
        });
    }
    
    // Function to update size options
    function updateSizeOptions(sizes) {
        // Clear current options
        sizeOptionsContainer.innerHTML = '';
        
        // Add new size options
        sizes.forEach((size, index) => {
            const sizeOption = document.createElement('div');
            sizeOption.className = `size-option ${index === 0 ? 'active' : ''}`;
            sizeOption.dataset.size = size.product_size;
            sizeOption.dataset.variantId = size.product_variantID;
            sizeOption.dataset.stock = size.product_stock;
            sizeOption.textContent = size.product_size;
            
            sizeOption.addEventListener('click', function() {
                // Update active size
                document.querySelectorAll('.size-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');
                
                // Get selected size and variant ID
                currentSize = this.dataset.size;
                currentVariantId = this.dataset.variantId;
                
                // Update variant ID
                if (variantIdInput) {
                    variantIdInput.value = currentVariantId;
                }
                
                // Update stock status
                updateStockStatus(this.dataset.stock);
                
                // Update max quantity based on stock
                const stock = parseInt(this.dataset.stock);
                quantityInput.max = stock;
                if (parseInt(quantityInput.value) > stock) {
                    quantityInput.value = stock;
                    quantityValue.value = stock;
                }
            });
            
            sizeOptionsContainer.appendChild(sizeOption);
        });
    }
    
    // Function to update stock status
    function updateStockStatus(stock) {
        stock = parseInt(stock);
        if (stock > 0) {
            stockStatus.textContent = `In Stock (${stock} available)`;
            stockStatus.style.color = '#28a745';
        } else {
            stockStatus.textContent = 'Out of Stock';
            stockStatus.style.color = '#dc3545';
        }
    }
    
    // Quantity buttons
    const decreaseBtn = document.querySelector('.decrease');
    const increaseBtn = document.querySelector('.increase');
    
    decreaseBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            value = value - 1;
            quantityInput.value = value;
            quantityValue.value = value;
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        const max = parseInt(quantityInput.max) || 10;
        if (value < max) {
            value = value + 1;
            quantityInput.value = value;
            quantityValue.value = value;
        }
    });
    
    // Update hidden input when quantity changes directly
    quantityInput.addEventListener('change', function() {
        const max = parseInt(this.max) || 10;
        let value = parseInt(this.value);
        
        if (isNaN(value) || value < 1) {
            value = 1;
        } else if (value > max) {
            value = max;
        }
        
        this.value = value;
        quantityValue.value = value;
    });
    
    // Form submission validation
    addToCartForm.addEventListener('submit', function(e) {
        const activeSize = document.querySelector('.size-option.active');
        if (activeSize && parseInt(activeSize.dataset.stock) <= 0) {
            e.preventDefault();
            alert('This product is currently out of stock in the selected size.');
        }
    });
});
</script>
@endpush
@endsection
