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
                            <th>Base Price (RM)</th>
                            <th>Actual Price (RM)</th>
                            <th>Discount</th>
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
                                <td>{{ $product->product_price ? number_format($product->product_price, 2) : 'N/A' }}</td>
                                <td>{{ number_format($product->actual_price, 2) }}</td>
                                <td>
                                    @if($product->discount_percentage > 0)
                                        <span class="badge bg-danger">{{ $product->discount_percentage }}% OFF</span>
                                    @else
                                        <span class="badge bg-secondary">No Discount</span>
                                    @endif
                                </td>
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
                                        <i class="fas fa-chevron-down"></i> Details
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
                            <!-- Enhanced Variants Row -->
                            <tr class="variant-details" id="variants-{{ $product->productID }}" style="display: none;">
                                <td colspan="9" class="p-0">
                                    <div class="card mb-0 border-0 bg-light-subtle">
                                        <div class="card-body p-3">
                                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                                <span>Variants for {{ $product->product_name }}</span>
                                                <button class="btn btn-sm btn-outline-secondary toggle-variants" 
                                                        data-product-id="{{ $product->productID }}">
                                                    <i class="fas fa-times"></i> Close
                                                </button>
                                            </h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Variant ID</th>
                                                            <th>Color</th>
                                                            <th>Tones</th>
                                                            <th>Sizes & Stock</th>
                                                            <th>Images</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($product->variants as $variant)
                                                            <tr>
                                                                <td>{{ $variant->product_variantID }}</td>
                                                                <td>
                                                                    @if($variant->color)
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="color-swatch me-2" 
                                                                                     style="background-color: {{ $variant->color->color_code }};"></div>
                                                                            {{ $variant->color->color_name }}
                                                                        </div>
                                                                    @else
                                                                        <span class="text-muted">N/A</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @forelse($variant->tones as $tone)
                                                                        <span class="badge rounded-pill bg-primary me-1 mb-1">
                                                                            {{ $tone->tone_name }}
                                                                        </span>
                                                                    @empty
                                                                        <span class="text-muted">N/A</span>
                                                                    @endforelse
                                                                </td>
                                                                <td>
                                                                    @forelse($variant->productSizings as $sizing)
                                                                        <div class="d-inline-block me-2 mb-2">
                                                                            <span class="badge bg-dark rounded-pill">
                                                                                {{ $sizing->product_size }}: {{ $sizing->product_stock }}
                                                                            </span>
                                                                        </div>
                                                                    @empty
                                                                        <span class="text-muted">No sizes</span>
                                                                    @endforelse
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        @forelse($variant->variantImages as $image)
                                                                            <img src="{{ asset('storage/' . $image->product_image) }}" 
                                                                                 alt="Variant Image" class="img-thumbnail" 
                                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                                        @empty
                                                                            <span class="text-muted">No images</span>
                                                                        @endforelse
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <a href="{{ route('products.variants.edit', $variant->product_variantID) }}" 
                                                                               class="btn btn-sm btn-primary" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="{{ route('products.variants.destroy', $variant->product_variantID) }}" 
                                                                                  method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                                    title="Delete"
                                                                                    onclick="return confirm('Delete this variant?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center py-3">
                                                                    <div class="text-muted">No variants found</div>
                                                                    <a href="{{ route('products.variants.create', $product->productID) }}" 
                                                                           class="btn btn-sm btn-primary mt-2">
                                                                        <i class="fas fa-plus me-1"></i> Add Variant
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No products found</td>
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
    // Consolidated toggle functionality
    $(document).on('click', '.toggle-variants', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const productId = $(this).data('product-id');
        const variantRow = $('#variants-' + productId);
        const icon = $(this).find('i');
        
        if (variantRow.is(':visible')) {
            variantRow.slideUp(300);
            icon.removeClass('fa-chevron-up fa-times').addClass('fa-chevron-down');
            $(this).html('<i class="fas fa-chevron-down"></i> Details');
        } else {
            variantRow.slideDown(300);
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $(this).html('<i class="fas fa-chevron-up"></i> Hide');
        }
    });

    // Product search functionality
    $('#productSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.product-row').each(function() {
            const productName = $(this).find('td:nth-child(2)').text().toLowerCase();
            const productDesc = $(this).find('td:nth-child(6)').text().toLowerCase();
            const productId = $(this).data('product-id');
            const variantRow = $('#variants-' + productId);
            
            if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                $(this).show();
                if (variantRow && variantRow.css('display') !== 'table-row') {
                    variantRow.hide();
                }
            } else {
                $(this).hide();
                if (variantRow) {
                    variantRow.hide();
                }
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

