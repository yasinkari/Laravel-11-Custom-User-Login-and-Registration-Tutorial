@extends('layout.admin_layout')

@section('title', 'Manage Promotions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Promotions</h1>
        <a href="{{ route('promotions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Promotion
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Promotions</h6>
        </div>
        <div class="card-body">
            @if($promotions->isEmpty())
                <div class="alert alert-info">
                    No promotions found. Click "Add New Promotion" to create one.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Promotion Name</th>
                                <th>Type</th>
                                <th>Product</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->promotionID }}</td>
                                    <td>{{ $promotion->promotion_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $promotion->promotion_type === 'discount' ? 'danger' : 
                                            ($promotion->promotion_type === 'bundle' ? 'success' : 
                                            ($promotion->promotion_type === 'clearance' ? 'warning' : 
                                            ($promotion->promotion_type === 'seasonal' ? 'info' : 'primary'))) }} text-white">
                                            {{ ucfirst($promotion->promotion_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $promotion->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $promotion->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('promotions.edit', $promotion->promotionID) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('promotions.destroy', $promotion->promotionID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $promotions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection