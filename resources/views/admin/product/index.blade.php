@extends('layout.admin_layout')

@section('title', 'Product Management')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Product Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Product
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
            <div class="input-group w-25">
                <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="productsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th> 
                            <th>Price (RM)</th>
                            <th>Description</th>
                            <th>Visibility</th>
                            <th>Variants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr data-product-id="{{ $product->productID }}" class="product-row">
                                <td>{{ $product->productID }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ number_format($product->product_price, 2) }}</td>
                                <td>{{ Str::limit($product->product_description, 100) }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-visibility" type="checkbox" 
                                               data-product-id="{{ $product->productID }}" 
                                               {{ $product->is_visible ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $product->is_visible ? 'Visible' : 'Hidden' }}</label>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->variants->count() }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2 toggle-variants" 
                                            data-product-id="{{ $product->productID }}">
                                        <i class="fas fa-chevron-down"></i> View
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->productID) }}" 
                                       class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->productID) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Variants Row (Hidden by Default) -->
                            <tr class="variant-details" id="variants-{{ $product->productID }}" style="display: none;">
                                <td colspan="6" class="p-0">
                                    <div class="card mb-0 border-0">
                                        <div class="card-body bg-light">
                                            <h6 class="mb-3">Variants for {{ $product->product_name }}</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Tone</th>
                                                            <th>Color</th>
                                                            <th>Size</th>
                                                            <th>Stock</th>
                                                            <th>Image</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($product->variants as $variant)
                                                            <tr>
                                                                <td>{{ $variant->product_variantID }}</td>
                                                                <td>{{ $variant->tone->tone_name ?? 'N/A' }}</td>
                                                                <td>
                                                                    @if($variant->color)
                                                                        <div class="d-flex align-items-center">
                                                                            <div style="width: 20px; height: 20px; background-color: {{ $variant->color->color_code }}; 
                                                                                        border-radius: 50%; margin-right: 5px;"></div>
                                                                            {{ $variant->color->color_name }}
                                                                        </div>
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>{{ $variant->product_size }}</td>
                                                                <td>{{ $variant->product_stock }}</td>
                                                                <td>
                                                                    @if($variant->product_image)
                                                                        <img src="{{ asset('storage/' . $variant->product_image) }}" 
                                                                             alt="Variant Image" class="img-thumbnail" 
                                                                             style="max-width: 50px;">
                                                                    @else
                                                                        No Image
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">No variants found for this product.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-3 text-end">
                                                <a href="{{ route('products.edit', $product->productID) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit me-1"></i>Edit Variants
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($products) && method_exists($products, 'links'))
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} 
                        of {{ $products->total() }} entries
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle variant details
    const toggleButtons = document.querySelectorAll('.toggle-variants');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const variantRow = document.getElementById('variants-' + productId);
            const icon = this.querySelector('i');
            
            if (variantRow.style.display === 'none') {
                variantRow.style.display = 'table-row';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                variantRow.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });

    // Product search functionality
    const searchInput = document.getElementById('productSearch');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const productRows = document.querySelectorAll('.product-row');
        
        productRows.forEach(row => {
            const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const productDesc = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const productId = row.getAttribute('data-product-id');
            const variantRow = document.getElementById('variants-' + productId);
            
            if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                row.style.display = '';
                if (variantRow) {
                    // Keep variant row hidden unless it was explicitly shown
                    if (variantRow.style.display !== 'table-row') {
                        variantRow.style.display = 'none';
                    }
                }
            } else {
                row.style.display = 'none';
                if (variantRow) {
                    variantRow.style.display = 'none';
                }
            }
        });
    });
});
</script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle variant details
        const toggleButtons = document.querySelectorAll('.toggle-variants');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const variantRow = document.getElementById('variants-' + productId);
                const icon = this.querySelector('i');
                
                if (variantRow.style.display === 'none') {
                    variantRow.style.display = 'table-row';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    variantRow.style.display = 'none';
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
    
        // Handle visibility toggle
        $('.toggle-visibility').on('change', function() {
            const productId = $(this).data('product-id');
            const isVisible = $(this).prop('checked') ? 1 : 0;
            const label = $(this).next('label');
            
            $.ajax({
                url: `/admin/products/${productId}/visibility`,
                type: 'PATCH',
                data: {
                    is_visible: isVisible,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    label.text(isVisible ? 'Visible' : 'Hidden');
                    
                    // Show success message
                    const alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Product visibility updated successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('.container-fluid').prepend(alertHtml);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        $('.alert').alert('close');
                    }, 3000);
                },
                error: function(xhr) {
                    console.error('Error updating visibility:', xhr);
                    
                    // Revert the toggle if there was an error
                    $(this).prop('checked', !isVisible);
                    
                    // Show error message
                    const alertHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Failed to update product visibility.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('.container-fluid').prepend(alertHtml);
                }
            });
        });
    });
</script>
@endpush
