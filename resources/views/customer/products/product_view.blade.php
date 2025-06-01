@extends('layout.layout')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"> 

<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="card">
                {{-- Main Image --}}
                <img src="{{ asset($data[array_key_first($data)]['variant_images'][0]['product_image'] ?? '') }}" 
                     class="card-img-top main-product-image" 
                     alt="Product Image" 
                     id="main-product-image">
                <div class="card-body">
                    <div class="row g-2 thumbnail-gallery" id="variant-thumbnails">
                        {{-- Thumbnails --}}
                        @foreach($data as $variantId => $variant)
                            @foreach($variant['variant_images'] as $image)
                                <div class="col-3">
                                    <div class="thumbnail-item">
                                        <img src="{{ asset($image['product_image']) }}" 
                                             class="img-thumbnail" 
                                             alt="Product variant thumbnail" 
                                             onclick="updateMainImage('{{ asset($image['product_image']) }}', this)">
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="h2 mb-3">{{ $product->product_name }}</h1>
            <div class="mb-3">
                @if($product->actual_price < $product->product_price)
                    <span class="h4 me-2">RM{{ number_format($product->actual_price, 2) }}</span>
                    <span class="text-muted text-decoration-line-through">RM{{ number_format($product->product_price, 2) }}</span>
                    <span class="badge bg-danger ms-2">SALE!</span>
                @else
                    <span class="h4 me-2">RM{{ number_format($product->product_price, 2) }}</span>
                @endif
            </div>

            {{-- Updated Rating Display --}}
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <div class="text-warning me-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <i class="fas fa-star"></i>
                            @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="me-2">{{ $averageRating }} out of 5</span>
                    <span class="text-muted">({{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }})</span>
                </div>
            </div>

            <p class="mb-4">{{ $product->product_description }}</p>

            <!-- Variant Selection Form -->
            <div class="variant-selection">
                <form id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->productID }}">
                    <input type="hidden" name="variant_id" id="selected_variant_id">

                    {{-- Color Selection --}}
                    <div class="mb-4">
                        <h6 class="mb-2">Color</h6>
                        <div class="color-radio-grid">
                            @foreach($product_variant["product"]["variants"] as $variantId => $variant)
                                <div class="color-radio-item">
                                    <input type="radio"
                                           class="btn-check"
                                           name="selected_color"
                                           id="color_{{ $variantId }}"
                                           value="{{ $variantId }}"
                                           @if($loop->first) checked @endif>
                                    <label class="color-btn"
                                           for="color_{{ $variantId }}"
                                           style="background-color: {{ $variant['color_code'] }};"></label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Size Selection --}}
                    <div class="mb-3">
                        <label class="form-label">Size Selection</label>
                        <div id="size-options" class="d-flex flex-wrap gap-2">
                            {{-- Size options will be loaded here by JavaScript --}}
                        </div>
                    </div>

                    {{-- Tone Display --}}
                    <div class="mb-3">
                        <label class="form-label">Available Tones</label>
                        <div id="tone-options" class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- Tone options will be loaded here by JavaScript --}}
                        </div>
                    </div>

                    {{-- Quantity Selection --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <label for="quantity" class="me-2">Quantity:</label>
                            <input type="number" class="form-control w-auto" id="quantity" name="quantity" value="1" min="1" max="10">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary-custom" onclick="addToCart()">Add to Cart</button>
                        {{-- Add to Wishlist Button (Placeholder) --}}
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="far fa-heart me-2"></i>Add to Wishlist
                        </button>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck text-primary me-2"></i>
                            <span>Free shipping on orders over $50</span> {{-- Placeholder --}}
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-undo text-primary me-2"></i>
                            <span>30-day return policy</span> {{-- Placeholder --}}
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <span>2-year warranty</span> {{-- Placeholder --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Product Ratings</h3>
                </div>
                <div class="card-body">
                    @if($totalReviews > 0)
                        <div class="row">
                            <!-- Rating Summary -->
                            <div class="col-md-4 mb-4">
                                <div class="text-center">
                                    <h2 class="display-4 mb-0">{{ $averageRating }}</h2>
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($averageRating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-muted">out of 5</p>
                                </div>
                            </div>

                            <!-- Rating Breakdown -->
                            <div class="col-md-8 mb-4">
                                @foreach($ratingBreakdown as $rating => $data)
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2">{{ $rating }} Star</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                 style="width: {{ $data['percentage'] }}%" 
                                                 aria-valuenow="{{ $data['percentage'] }}" 
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-muted">({{ $data['count'] }})</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="mb-4">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary active" data-filter="all">All</button>
                                @foreach($ratingBreakdown as $rating => $data)
                                    @if($data['count'] > 0)
                                        <button type="button" class="btn btn-outline-primary" data-filter="{{ $rating }}">{{ $rating }} Star ({{ $data['count'] }})</button>
                                    @endif
                                @endforeach
                                <button type="button" class="btn btn-outline-primary" data-filter="comments">With Comments ({{ $reviews->where('comment', '!=', '')->count() }})</button>
                            </div>
                        </div>

                        <!-- Individual Reviews -->
                        <div class="reviews-container">
                            @foreach($reviews as $review)
                                <div class="review-item border-bottom pb-3 mb-3" data-rating="{{ $review->rating }}" data-has-comment="{{ !empty($review->comment) ? 'true' : 'false' }}">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2">{{ $review->order->user->name ?? 'Anonymous' }}</strong>
                                                <div class="text-warning me-2">
                                                    {!! $review->star_display !!}
                                                </div>
                                            </div>
                                            <p class="text-muted small mb-1">{{ $review->created_at->format('Y-m-d H:i') }}</p>
                                            @if(!empty($review->comment))
                                                <p class="mb-0">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-star-o fa-3x text-muted mb-3"></i>
                            <h5>No reviews yet</h5>
                            <p class="text-muted">Be the first to review this product!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Global variables
        let selectedVariantId = null;
        const productData = @json($data);

        // Function to update size options based on selected variant
        function updateSizeOptions(variantId) {
            const variant = productData[variantId];
            const availableSizings = variant ? variant.sizings : [];
            let firstAvailableSizeId = null;

            // Clear existing size options
            $('#size-options').empty();

            // Debugging logs
            console.log('updateSizeOptions called with variantId:', variantId);
            console.log('Variant data:', variant);
            console.log('Available Sizings:', availableSizings);

            if (availableSizings.length > 0) {
                // Build and append available size options
                availableSizings.forEach(function(sizing, index) {
                    const sizingId = sizing.product_sizingID;
                    const size = sizing.product_size;
                    const stock = sizing.product_stock;

                    const sizeHtml = `
                        <div class="size-option">
                            <input type="radio"
                                   class="btn-check size-radio"
                                   name="selected_size"
                                   id="size_${sizingId}"
                                   value="${sizingId}">
                            <label class="btn btn-outline-primary size-btn"
                                   for="size_${sizingId}">
                                ${size.toUpperCase()}
                                <small class="d-block">(Stock: <span id="stock_${sizingId}">${stock}</span>)</small>
                            </label>
                        </div>
                    `;
                    $('#size-options').append(sizeHtml);

                    // Set the first available size to be checked
                    if (index === 0) {
                        firstAvailableSizeId = sizingId;
                    }
                });

                // Check the first available size after appending
                if (firstAvailableSizeId !== null) {
                    $('#size_' + firstAvailableSizeId).prop('checked', true);
                }
            } else {
                // Display a message if no sizes are available for this variant
                $('#size-options').html('<p>No sizes available for this color.</p>');
            }
        }

        // Function to update tone display based on selected variant
        function updateToneDisplay(variantId) {
            const variant = productData[variantId];
            const tones = variant ? variant.tones : [];

            // Clear existing tone options
            $('#tone-options').empty();

            // Add new tone options as non-interactive elements
            if (tones.length > 0) {
                tones.forEach((tone) => {
                    const toneDisplay = `
                        <div class="tone-display d-flex align-items-center gap-1">
                            <span class="tone-swatch" style="background-color: ${tone.tone_code}; width: 20px; height: 20px; height: 20px; display: inline-block; border-radius: 50%; border: 1px solid #ccc;"></span>
                            <span>${tone.tone_name}</span>
                        </div>
                    `;
                    $('#tone-options').append(toneDisplay);
                });
            } else {
                 $('#tone-options').html('<p>No suggested tones for this variant.</p>');
            }
        }

        // Handle color selection change
        $('input[name="selected_color"]').change(function() {
            selectedVariantId = $(this).val();
            $('#selected_variant_id').val(selectedVariantId);
            updateSizeOptions(selectedVariantId);
            updateToneDisplay(selectedVariantId);

            // Update main image based on selected variant (assuming first image)
            const variant = productData[selectedVariantId];
            if (variant && variant.variant_images && variant.variant_images.length > 0) {
                $('#main-product-image').attr('src', variant.variant_images[0].product_image);
            }
        });

        // Initial load: Trigger change event for the initially checked color to populate sizes and tones
        const initialVariantId = $('input[name="selected_color"]:checked').val();
        if (initialVariantId) {
             selectedVariantId = initialVariantId;
             $('#selected_variant_id').val(selectedVariantId);
             updateSizeOptions(selectedVariantId);
             updateToneDisplay(selectedVariantId);
        } else {
            // If no color is initially checked, ensure all sizes are disabled and tone display is empty
            updateSizeOptions(null);
            updateToneDisplay(null);
        }

        // Function to update main image (from thumbnail click)
        window.updateMainImage = function(imageUrl, element) {
            $('#main-product-image').attr('src', imageUrl);
            // Optional: Add active class to thumbnail
            $('.thumbnail-item img').removeClass('active');
            $(element).addClass('active');
        };

        // Function to collect selected color, size, and quantity for adding to cart
        window.addToCart = function() {
            
            const selectedColorVariantId = $('input[name="selected_color"]:checked').val();
            const selectedSizeId = $('input[name="selected_size"]:checked').val();
            const quantity = $('#quantity').val();

            // You can now use selectedColorVariantId, selectedSizeId, and quantity
            // For example, log them to the console or send them via AJAX
            console.log('Selected Variant ID (Color):', selectedColorVariantId);
            console.log('Selected Size ID:', selectedSizeId);
            console.log('Quantity:', quantity);


            // Example AJAX call (you'll need to implement the backend route)
            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    variant_id: selectedColorVariantId,
                    size_id: selectedSizeId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        updateCartBadge();
                        showToast('success', response.message);
                        if (response.cart_count) {
                            // Update cart count in UI
                        }
                    }
                },
                error: function(xhr) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        showToast('error', response.message || 'An error occurred while adding to cart');
                    } catch (e) {
                        showToast('error', 'An error occurred while adding to cart');
                    }
                }
            });
        };
    });
</script>
@endpush

@section('css')
<style>
    /* Add custom styles here if needed, or keep the existing responsive styles */
    .main-product-image {
        max-height: 500px; /* Adjust as needed */
        width: auto;
        display: block;
        margin: 0 auto;
    }

    .thumbnail-item img {
        cursor: pointer;
        border: 1px solid #ddd;
        padding: 5px;
        transition: border-color 0.2s ease-in-out;
    }

    .thumbnail-item img:hover, .thumbnail-item img.active {
        border-color: #007bff;
    }

    .color-radio-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .color-radio-item input[type="radio"] {
        display: none;
    }

    .color-radio-item label {
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s ease-in-out;
    }

    .color-radio-item input[type="radio"]:checked + label {
        border-color: #007bff;
    }

    .color-radio-item label:hover {
        opacity: 0.8;
    }

    .size-option input[type="radio"] {
        display: none;
    }

    .size-option label {
        cursor: pointer;
    }

    .size-option input[type="radio"]:checked + label {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .tone-swatch {
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 50%;
        border: 1px solid #ccc;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) { /* Tablet and smaller */
        .product-details .row > div {
            margin-bottom: 20px;
        }
        .main-product-image {
            max-height: 350px; /* Adjust main image height */
        }
        .thumbnail-gallery .col-3 {
            flex: 0 0 25%; /* Ensure 4 thumbnails per row */
            max-width: 25%;
        }
        .product-info {
            padding: 20px;
        }
        .product-title {
            font-size: 1.8rem; /* Adjust title size */
        }
        .color-radio-grid {
            gap: 8px;
        }
        .color-radio-item label {
            width: 35px;
            height: 35px;
        }
        .size-btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        #quantity {
            max-width: 80px;
        }
    }

    @media (max-width: 576px) { /* Mobile */
        .product-details .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        .main-product-image {
            max-height: 300px;
        }
        .thumbnail-gallery .col-3 {
            flex: 0 0 33.33%; /* 3 thumbnails per row on mobile */
            max-width: 33.33%;
        }
        .product-title {
            font-size: 1.5rem;
        }
        .current-price {
            font-size: 1.2rem;
        }
        .original-price {
            font-size: 0.9rem;
        }
        .color-radio-grid {
            gap: 5px;
        }
        .color-radio-item label {
            width: 30px;
            height: 30px;
        }
        .size-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .btn-primary-custom {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    }

    .review-item {
        transition: opacity 0.3s ease;
    }
    
    .progress {
        background-color: #e9ecef;
    }
    
    .btn-group .btn {
        border-radius: 0;
    }
    
    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
</style>
@endsection