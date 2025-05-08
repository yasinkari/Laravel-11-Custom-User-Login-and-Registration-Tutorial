@extends('layout.admin_layout')

@section('title', 'Create Promotion')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Promotion</h1>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Promotions
        </a>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Promotion Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('promotions.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="promotion_name" class="form-label">Promotion Name</label>
                    <input type="text" class="form-control @error('promotion_name') is-invalid @enderror" 
                           id="promotion_name" name="promotion_name" value="{{ old('promotion_name') }}" required>
                    @error('promotion_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="promotion_type" class="form-label">Promotion Type</label>
                    <select class="form-select @error('promotion_type') is-invalid @enderror" 
                            id="promotion_type" name="promotion_type" required>
                        <option value="">Select a promotion type</option>
                        @foreach($promotionTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('promotion_type') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('promotion_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                           {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Select Products</label>
                    <div class="card">
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="products[]" value="{{ $product->productID }}" 
                                                   id="product_{{ $product->productID }}"
                                                   {{ in_array($product->productID, old('products', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="product_{{ $product->productID }}">
                                                {{ $product->product_name }} (RM{{ number_format($product->product_price, 2) }})
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @error('products')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Promotion</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handling
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        });
    });
</script>
@endpush
@endsection