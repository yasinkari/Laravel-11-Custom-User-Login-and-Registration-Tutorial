@extends('layout.admin_layout')
@section('title', 'Edit Product')

@section('content')
<<<<<<< HEAD
<h1 class="mb-4">Edit Product</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')  <!-- This ensures it is a PUT request for updating -->
    
    <!-- Product Name -->
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>

    <!-- Price -->
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" id="image" name="image" class="form-control">
        @if($product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100" height="100">
                <p>Current Image</p>
            </div>
        @endif
    </div>

    <!-- Variants Section -->
    <h3>Product Variants</h3>
    <div id="variant-fields">
        @foreach ($product->details['variants'] as $key => $variant)
        <div class="variant mb-4 p-3 border rounded shadow-sm">
            <h5>Variant {{ $key + 1 }}</h5>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="variants[{{ $key }}][color]" class="form-control" value="{{ old('variants.' . $key . '.color', $variant['color']) }}" required>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="variants[{{ $key }}][size]" class="form-control" value="{{ old('variants.' . $key . '.size', $variant['size']) }}" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="variants[{{ $key }}][stock]" class="form-control" value="{{ old('variants.' . $key . '.stock', $variant['stock']) }}" required>
            </div>
        </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-outline-secondary" onclick="addVariant()">Add Another Variant</button>

    <br><br>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>

<script>
    let variantCount = {{ count($product->details['variants']) }};
    function addVariant() {
        let variantHTML = `
            <div class="variant mb-4 p-3 border rounded shadow-sm">
                <h5>Variant ${variantCount + 1}</h5>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="variants[${variantCount}][color]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="variants[${variantCount}][size]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="variants[${variantCount}][stock]" class="form-control" required>
                </div>
            </div>
        `;
        document.getElementById('variant-fields').insertAdjacentHTML('beforeend', variantHTML);
        variantCount++;
    }
</script>

@endsection
=======
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Basic Product Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->productID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" 
                                   value="{{ old('product_name', $product->product_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="product_price" class="form-label">Price (RM)</label>
                            <div class="input-group">
                                <span class="input-group-text">RM</span>
                                <input type="number" class="form-control" id="product_price" name="product_price" 
                                       step="0.01" min="0" value="{{ old('product_price', $product->product_price) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="product_description" class="form-label">Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" 
                                      rows="4" required>{{ old('product_description', $product->product_description) }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Variants -->
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Product Variants</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#variantModal">
                        <i class="fas fa-plus me-1"></i>Add Variant
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Tone</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $variant)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $variant->product_image) }}" 
                                             alt="Product Variant" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle border" style="width: 20px; height: 20px; background-color: {{ $variant->tone->tone_code }}"></div>
                                            {{ $variant->tone->tone_name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle border" style="width: 20px; height: 20px; background-color: {{ $variant->color->color_code }}"></div>
                                            {{ $variant->color->color_name }}
                                        </div>
                                    </td>
                                    <td>{{ $variant->product_size }}</td>
                                    <td>{{ $variant->product_stock }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary edit-variant" 
                                                data-variant-id="{{ $variant->product_variantID }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-variant"
                                                data-variant-id="{{ $variant->product_variantID }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Variant Modal -->
@include('admin.product.partials.variant_modal', ['tones' => $tones, 'colors' => $colors])

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Edit variant
    $('.edit-variant').click(function() {
        const variantId = $(this).data('variant-id');
        $.get(`/admin/variants/${variantId}/edit`, function(data) {
            $('#variantForm').attr('action', `/admin/variants/${variantId}`);
            $('#variantForm').append('@method("PUT")');
            
            // Update tone select and preview
            $('#toneID').val(data.tone.toneID);
            const tonePreview = $('#toneID').closest('.d-flex').find('.color-preview');
            tonePreview.css('background-color', data.tone.tone_code);

            // Update color select and preview
            $('#colorID').val(data.color.colorID);
            const colorPreview = $('#colorID').closest('.d-flex').find('.color-preview');
            colorPreview.css('background-color', data.color.color_code);

            $('#product_size').val(data.product_size);
            $('#product_stock').val(data.product_stock);
            $('#variantModal').modal('show');
        });
    });

    // Update color previews on select change
    $('.tone-select, .color-select').on('change', function() {
        const preview = $(this).closest('.d-flex').find('.color-preview');
        const selected = $(this).find('option:selected');
        const code = selected.data('tone') || selected.data('color');
        preview.css('background-color', code || 'transparent');
    });

    // Delete variant
    $('.delete-variant').click(function() {
        if (confirm('Are you sure you want to delete this variant?')) {
            const variantId = $(this).data('variant-id');
            $.ajax({
                url: `/admin/variants/${variantId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });

    // Preview colors
    $('.tone-select, .color-select').change(function() {
        const preview = $(this).next('.color-preview');
        const selected = $(this).find('option:selected');
        const code = selected.data('color') || selected.data('tone');
        preview.css('background-color', code || 'transparent');
    });
});
</script>
@endpush
>>>>>>> master
