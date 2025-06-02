@extends('layout.layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Reviews for Cart #{{ $cartID }}</h2>
            
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
                            <p class="text-muted">No reviews available for this cart.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection