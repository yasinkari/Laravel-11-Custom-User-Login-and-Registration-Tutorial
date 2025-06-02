@extends('layout.admin_layout')

@section('title', 'Review Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Review Management</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Reviews</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>{{ $review->reviewID }}</td>
                                <td>{{ $review->order->user->name ?? 'Unknown' }}</td>
                                <td>
                                    @php
                                        $product = $review->order->cartRecords->first()->productSizing->productVariant->product ?? null;
                                    @endphp
                                    {{ $product ? $product->product_name : 'Unknown Product' }}
                                </td>
                                <td>
                                    <div class="text-warning">
                                        {!! $review->star_display !!}
                                    </div>
                                </td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href=