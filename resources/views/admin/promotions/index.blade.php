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

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
                                <th>Products</th>
                                <th>Status</th>
                                <th>Date Range</th>
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
                                    <td>
                                        <span class="badge bg-secondary">{{ $promotion->products->count() }}</span>
                                        @if($promotion->products->count() > 0)
                                            <button type="button" class="btn btn-sm btn-link view-products" 
                                                    data-bs-toggle="modal" data-bs-target="#productsModal" 
                                                    data-products="{{ json_encode($promotion->products->pluck('product_name')) }}">
                                                View
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($promotion->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($promotion->start_date && $promotion->end_date)
                                            {{ date('M d, Y', strtotime($promotion->start_date)) }} - 
                                            {{ date('M d, Y', strtotime($promotion->end_date)) }}
                                        @elseif($promotion->start_date)
                                            From {{ date('M d, Y', strtotime($promotion->start_date)) }}
                                        @elseif($promotion->end_date)
                                            Until {{ date('M d, Y', strtotime($promotion->end_date)) }}
                                        @else
                                            No date limit
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('promotions.edit', $promotion->promotionID) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-promotion" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                    data-id="{{ $promotion->promotionID }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $promotions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this promotion? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productsModalLabel">Products in Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="productsList" class="list-group">
                    <!-- Products will be populated here via JavaScript -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle delete confirmation
    document.addEventListener('DOMContentLoaded', function() {
        // Set up delete confirmation
        const deleteButtons = document.querySelectorAll('.delete-promotion');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteForm').action = `/admin/promotions/${id}`;
            });
        });
        
        // Set up products modal
        const viewButtons = document.querySelectorAll('.view-products');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const products = JSON.parse(this.getAttribute('data-products'));
                const productsList = document.getElementById('productsList');
                productsList.innerHTML = '';
                
                products.forEach(product => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = product;
                    productsList.appendChild(li);
                });
            });
        });
    });
</script>
@endpush
@endsection