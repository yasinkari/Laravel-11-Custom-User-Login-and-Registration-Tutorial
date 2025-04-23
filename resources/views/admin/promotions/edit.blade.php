@extends('layout.admin_layout')

@section('title', 'Edit Promotion')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Promotion</h1>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Promotions
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Promotion Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('promotions.update', $promotion->promotionID) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="promotion_name" class="form-label">Promotion Name</label>
                    <input type="text" class="form-control @error('promotion_name') is-invalid @enderror" 
                           id="promotion_name" name="promotion_name" 
                           value="{{ old('promotion_name', $promotion->promotion_name) }}" required>
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
                            <option value="{{ $value }}" 
                                {{ old('promotion_type', $promotion->promotion_type) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('promotion_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="productID" class="form-label">Product</label>
                    <select class="form-select @error('productID') is-invalid @enderror" 
                            id="productID" name="productID" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->productID }}" 
                                {{ old('productID', $promotion->productID) == $product->productID ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('productID')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Promotion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection