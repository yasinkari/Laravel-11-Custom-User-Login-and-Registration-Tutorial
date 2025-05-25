@extends('layout.layout')

@section('content')
<div class="product-details">
    {{dd($data)}}
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image-gallery">
                    <div class="main-image mb-4">
                        <img src="" alt="{{ $product->product_name }}" class="img-fluid main-product-image" id="main-product-image">
                    </div>
                    <div class="thumbnail-gallery">
                        <div class="row g-2" id="variant-thumbnails"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->product_name }}</h1>
                    
                    <div class="product-price-section mb-4">
                        @if($product->actual_price < $product->product_price)
                            <div class="price-display">
                                <span class="current-price">RM{{ number_format($product->actual_price, 2) }}</span>
                                <span class="original-price">RM{{ number_format($product->product_price, 2) }}</span>
                            </div>
                            <div class="sale-badge">SALE!</div>
                        @else
                            <div class="price-display">
                                <span class="current-price">RM{{ number_format($product->product_price, 2) }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="variant-selection">
                        <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->productID }}">
                            <input type="hidden" name="variant_id" id="selected_variant_id">
                            
                            <div class="color-selection mb-4">
                                <label class="variant-label">Colors</label>
                                <div class="color-options" id="color-options">
                                    @foreach($data['tones'] as $tone)
                                        @foreach($tone['colors'] as $color)
                                            <div class="color-box-option" 
                                                 data-color-id="{{ $color['color_id'] }}"
                                                 data-tone-id="{{ $tone['tone_id'] }}">
                                                <div class="color-box" style="background-color: {{ $color['color_code'] }}">
                                                    <div class="color-check">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                                <span class="color-name">{{ $color['color_name'] }}</span>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="variant-label">Size</label>
                                <div class="size-options d-flex flex-wrap gap-2" id="size-buttons-container">
                                    <button type="button" class="size-btn" data-size="XXS" disabled>XXS</button>
                                    <button type="button" class="size-btn" data-size="XS" disabled>XS</button>
                                    <button type="button" class="size-btn" data-size="S" disabled>S</button>
                                    <button type="button" class="size-btn" data-size="M" disabled>M</button>
                                    <button type="button" class="size-btn" data-size="L" disabled>L</button>
                                    <button type="button" class="size-btn" data-size="XL" disabled>XL</button>
                                    <button type="button" class="size-btn" data-size="XXL" disabled>XXL</button>
                                </div>
                            </div>

                            <div class="tone-selection mb-4" style="display: none;">
                                <label class="variant-label">Tone</label>
                                <div class="tone-options" id="tone-options"></div>
                            </div>

                            <div class="selected-variants mt-4">
                                <div id="selected-colors-info"></div>
                            </div>

                            <div class="tone-selection mb-4" style="display: none;">
                                <label class="variant-label">Tone</label>
                                <div class="tone-options" id="tone-options"></div>
                            </div>

                            <div class="size-selection mb-4" style="display: none;">
                                <label class="variant-label">Size</label>
                                <div class="size-options" id="size-options"></div>
                            </div>

                            <div class="quantity-section mb-4" style="display: none;">
                                <label class="variant-label">Quantity</label>
                                <div class="quantity-input">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="number" name="quantity" value="1" min="1" class="qty-input">
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                            </div>

                            <button type="submit" class="btn-add-to-cart" disabled>
                                Add To Cart »
                            </button>
                        </form>

                        <div class="whatsapp-order mt-3">
                            <button class="btn-whatsapp-order w-100">
                                Order Melalui Whatsapp <i class="fab fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.product-image-gallery {
    position: relative;
    margin-bottom: 2rem;
}

.main-image {
    border: 1px solid #eee;
    padding: 10px;
    background: white;
    border-radius: 8px;
    margin-bottom: 1rem;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-image img {
    max-height: 100%;
    width: auto;
    object-fit: contain;
}

.thumbnail-gallery {
    margin-top: 1rem;
}

.thumbnail-item {
    cursor: pointer;
    border: 2px solid transparent;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.thumbnail-item.active {
    border-color: #0f2c1f;
}

.thumbnail-item img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.product-title {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.price-display {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.current-price {
    font-size: 1.8rem;
    font-weight: bold;
    color: #ff6b6b;
}

.original-price {
    font-size: 1.2rem;
    text-decoration: line-through;
    color: #868e96;
}

.sale-badge {
    display: inline-block;
    background-color: #ff6b6b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.size-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #dee2e6;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-btn:hover {
    border-color: #0f2c1f;
}

.size-btn.selected {
    background: #0f2c1f;
    color: white;
    border-color: #0f2c1f;
}

.color-options {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.color-box-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
}

.color-box {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    border: 2px solid #ddd;
    position: relative;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.color-box:hover {
    transform: scale(1.05);
    border-color: #999;
}

.color-box.selected {
    border-color: #333;
}

.color-check {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-shadow: 0 0 2px rgba(0,0,0,0.5);
}

.color-box.selected .color-check {
    display: block;
}

.color-name {
    font-size: 12px;
    text-align: center;
    color: #666;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    const productData = @json($data);
    let selectedSize = null;
    let selectedColor = null;
    let selectedTone = null;
    
    // Handle color selection
    $('.color-box-option').click(function() {
        const colorId = $(this).data('color-id');
        const toneId = $(this).data('tone-id');
        
        $('.color-box-option').removeClass('selected');
        $(this).addClass('selected');
        
        selectedColor = colorId;
        selectedTone = toneId;
        selectedSize = null; // Reset size selection when color changes
        
        // Reset size button states
        $('.size-btn').removeClass('selected').prop('disabled', true);
        
        // Find the tone and color data
        const tone = productData.tones.find(t => t.tone_id === toneId);
        const color = tone.colors.find(c => c.color_id === colorId);
        
        // Enable only available sizes for this color
        const availableSizes = color.sizes.map(s => s.size_name);
        $('.size-btn').each(function() {
            const sizeBtn = $(this);
            const size = sizeBtn.data('size');
            if (availableSizes.includes(size)) {
                sizeBtn.prop('disabled', false);
            }
        });
        
        // Update variant images
        updateVariantImages(color.sizes);
        updateAddToCartButton();
    });
    
    // Handle size selection
    $('.size-btn').click(function() {
        if (!$(this).prop('disabled')) {
            $('.size-btn').removeClass('selected');
            $(this).addClass('selected');
            selectedSize = $(this).data('size');
            updateAddToCartButton();
        }
    });
    
    // Handle quantity buttons
    $('.qty-btn.minus').click(function() {
        let qty = parseInt($('.qty-input').val());
        if (qty > 1) {
            $('.qty-input').val(qty - 1);
        }
    });
    
    $('.qty-btn.plus').click(function() {
        let qty = parseInt($('.qty-input').val());
        $('.qty-input').val(qty + 1);
    });
    
    function updateVariantImages(sizes) {
        // Get all unique images from the variants
        const images = [...new Set(sizes.map(size => size.product_image))];
        
        // Update main image
        if (images.length > 0) {
            $('#main-product-image').attr('src', images[0]);
        }
        
        // Update thumbnails
        const thumbnailsHtml = images.map((image, index) => `
            <div class="col-3">
                <div class="thumbnail-item ${index === 0 ? 'active' : ''}">
                    <img src="${image}" alt="Product variant" 
                         onclick="updateMainImage('${image}', this)">
                </div>
            </div>
        `).join('');
        
        $('#variant-thumbnails').html(thumbnailsHtml);
    }
    
    function updateAddToCartButton() {
        const isValid = selectedSize && selectedColor && selectedTone;
        $('.btn-add-to-cart').prop('disabled', !isValid);
        
        if (isValid) {
            const tone = productData.tones.find(t => t.tone_id === selectedTone);
            const color = tone.colors.find(c => c.color_id === selectedColor);
            const variant = color.sizes.find(s => s.size_name === selectedSize);
            
            if (variant) {
                $('#selected_variant_id').val(variant.variant_id);
            }
        }
    }
});

function updateMainImage(imageSrc, thumbnail) {
    $('#main-product-image').attr('src', imageSrc);
    $('.thumbnail-item').removeClass('active');
    $(thumbnail).closest('.thumbnail-item').addClass('active');
}
</script>
@endpush
@endsection

@push('styles')
<style>
.size-btn:disabled {
    background-color: #f5f5f5;
    border-color: #ddd;
    color: #999;
    cursor: not-allowed;
    opacity: 0.7;
}
</style>
@endpush