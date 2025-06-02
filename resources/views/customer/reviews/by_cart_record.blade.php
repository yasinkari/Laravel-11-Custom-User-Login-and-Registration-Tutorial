@extends('layout.layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Reviews for {{ $cartRecord->productSizing->productVariant->product->product_name }}</h2>
            <div class="mb-4">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/'.$cartRecord->productSizing->productVariant->variantImages->first()->product_image) }}" 
                         alt="{{ $cartRecord->productSizing->productVariant->product->product_name }}" 
                         class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h5 class="mb-1">{{ $cartRecord->productSizing->productVariant->product->product_name }}</h5>
                        <p class="text-muted mb-0">
                            Variant: {{ $cartRecord->productSizing->productVariant->variant_name }}
                            <span class="mx-1">·</span>
                            Size: {{ $cartRecord->productSizing->size }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Review Form Component -->
            @php
                $productID = $cartRecord->productSizing->productVariant->product->productID;
                $orderID = $cartRecord->cart->order->orderID;
                $existingReview = $reviews->first(function($review) use ($productID) {
                    return $review->order->cartRecords->contains(function($cartRecord) use ($productID) {
                        return $cartRecord->productSizing->productVariant->product->productID == $productID;
                    });
                });
            @endphp
            
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">{{ $existingReview ? 'Update Your Review' : 'Write a Review' }}</h3>
                </div>
                <div class="card-body">
                    <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="orderID" value="{{ $orderID }}">
                        <input type="hidden" name="productID" value="{{ $productID }}">
                        
                        <!-- Star Rating -->
                        <div class="form-group mb-3">
                            <label class="form-label">Your Rating</label>
                            <div class="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $existingReview && $existingReview->rating == $i ? 'checked' : '' }} required>
                                    <label for="star{{ $i }}" title="{{ $i }} stars"><i class="far fa-star"></i></label>
                                @endfor
                            </div>
                        </div>
                        
                        <!-- Review Comment -->
                        <div class="form-group mb-3">
                            <label for="comment" class="form-label">Your Review (Optional)</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Share your experience with this product...">{{ $existingReview ? $existingReview->comment : '' }}</textarea>
                        </div>
                        
                        <!-- After the comment textarea -->
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showName" name="showName" value="1" {{ $existingReview && $existingReview->showName ? 'checked' : '' }}>
                                <label class="form-check-label" for="showName">
                                    Show my name with this review
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            {{ $existingReview ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </form>
                </div>
            </div>
            
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

                        <!-- Individual Reviews -->
                        <div class="reviews-container">
                            @foreach($reviews as $review)
                                <div class="review-item border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2">
                                                    @if($review->showName)
                                                        {{ $review->order->user->name ?? 'Anonymous' }}
                                                    @else
                                                        Anonymous
                                                    @endif
                                                </strong>
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
                            <p class="text-muted">No reviews available for this product.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS for Star Rating -->
<style>
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        cursor: pointer;
        font-size: 1.5rem;
        padding: 0 0.1rem;
        color: #ddd;
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #ffc107;
    }
    
    .star-rating label:hover i,
    .star-rating label:hover ~ label i,
    .star-rating input:checked ~ label i {
        content: '\f005';
        font-weight: 900;
    }
</style>

<!-- JavaScript for Star Rating -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starLabels = document.querySelectorAll('.star-rating label');
        
        starLabels.forEach(label => {
            label.addEventListener('mouseover', function() {
                this.querySelector('i').classList.remove('far');
                this.querySelector('i').classList.add('fas');
                
                let prevSibling = this.previousElementSibling;
                while(prevSibling && prevSibling.tagName === 'LABEL') {
                    prevSibling.querySelector('i').classList.remove('far');
                    prevSibling.querySelector('i').classList.add('fas');
                    prevSibling = prevSibling.previousElementSibling;
                }
            });
            
            label.addEventListener('mouseout', function() {
                if (!this.previousElementSibling || !this.previousElementSibling.checked) {
                    this.querySelector('i').classList.remove('fas');
                    this.querySelector('i').classList.add('far');
                    
                    let prevSibling = this.previousElementSibling;
                    while(prevSibling && prevSibling.tagName === 'LABEL') {
                        if (!prevSibling.previousElementSibling || !prevSibling.previousElementSibling.checked) {
                            prevSibling.querySelector('i').classList.remove('fas');
                            prevSibling.querySelector('i').classList.add('far');
                        }
                        prevSibling = prevSibling.previousElementSibling;
                    }
                }
            });
        });
        
        // Initialize stars based on selected rating
        const checkedStar = document.querySelector('.star-rating input:checked');
        if (checkedStar) {
            const checkedLabel = document.querySelector(`label[for="${checkedStar.id}"]`);
            checkedLabel.querySelector('i').classList.remove('far');
            checkedLabel.querySelector('i').classList.add('fas');
            
            let prevSibling = checkedLabel.previousElementSibling;
            while(prevSibling && prevSibling.tagName === 'LABEL') {
                prevSibling.querySelector('i').classList.remove('far');
                prevSibling.querySelector('i').classList.add('fas');
                prevSibling = prevSibling.previousElementSibling;
            }
        }
    });
</script>
@endsection