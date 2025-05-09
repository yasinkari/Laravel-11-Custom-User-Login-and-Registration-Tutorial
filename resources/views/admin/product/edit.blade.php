@extends('layout.admin_layout')
@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                                <li class="breadcrumb-item active">Edit Product</li>
                            </ol>
                        </nav>
                    </div>
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

                <!-- Basic Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->productID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                               id="product_name" name="product_name" 
                                               value="{{ old('product_name', $product->product_name) }}" required>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Base Price (RM)</label>
                                        <input type="number" class="form-control @error('product_price') is-invalid @enderror" 
                                               id="product_price" name="product_price" 
                                               value="{{ old('product_price', $product->product_price) }}" 
                                               step="0.01" min="0">
                                        <small class="form-text text-muted">Optional</small>
                                        @error('product_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="actual_price" class="form-label">Actual Price (RM)</label>
                                        <input type="number" class="form-control @error('actual_price') is-invalid @enderror" 
                                               id="actual_price" name="actual_price" 
                                               value="{{ old('actual_price', $product->actual_price) }}" 
                                               step="0.01" min="0" required>
                                        @php
                                            $discount = 0;
                                            if ($product->actual_price > 0 && $product->product_price > 0 && $product->actual_price > $product->product_price) {
                                                $discount = round((($product->actual_price - $product->product_price) / $product->actual_price) * 100);
                                            }
                                        @endphp
                                        <div id="discount-indicator" class="mt-1 {{ $discount > 0 ? '' : 'd-none' }}">
                                            <span class="badge bg-danger">Discount: <span id="discount-percentage">{{ $discount }}</span>% OFF</span>
                                        </div>
                                        @error('actual_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Visibility</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" 
                                                   value="1" {{ $product->is_visible ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_visible">Product is visible to customers</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Product Description</label>
                                        <textarea class="form-control @error('product_description') is-invalid @enderror" 
                                                  id="product_description" name="product_description" 
                                                  rows="4" required>{{ old('product_description', $product->product_description) }}</textarea>
                                        @error('product_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Basic Info
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Variants Management Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Product Variants</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                            <i class="fas fa-plus-circle me-2"></i>Add New Variant
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
                                    @forelse($variants as $variant)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ Storage::url($variant->product_image) }}" 
                                                 alt="Variant" class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="tone-swatch me-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->tone->tone_code }}; border: 1px solid #ddd;"></div>
                                                {{ $variant->tone->tone_name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-swatch me-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->color->color_code }}; border: 1px solid #ddd;"></div>
                                                {{ $variant->color->color_name }}
                                            </div>
                                        </td>
                                        <td>{{ $variant->product_size }}</td>
                                        <td>{{ $variant->product_stock }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary me-2" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#editVariantModal{{ $variant->product_variantID }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#deleteVariantModal{{ $variant->product_variantID }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No variants found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $variants->firstItem() ?? 0 }} to {{ $variants->lastItem() ?? 0 }} 
                                of {{ $variants->total() }} entries 
                            </div>
                            {{ $variants->links() }}
                        </div>
                    </div>
                </div>

                <!-- Add Variant Modal -->
                <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addVariantModalLabel">Add New Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('products.variants.store', $product->productID) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tone</label>
                                            <select class="form-select" name="toneID" required>
                                                <option value="">Select Tone</option>
                                                @foreach($tones as $tone)
                                                    <option value="{{ $tone->toneID }}">{{ $tone->tone_name }}</option>
                                                @endforeach
                                            </select>
                                            @if(count($tones) > 0)
                                                <div class="mt-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="tone-swatch" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $tones[0]->tone_code }}; border: 1px solid #ddd;"></div>
                                                        <span class="ms-2">{{ $tones[0]->tone_name }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Color</label>
                                            <select class="form-select" name="colorID" required>
                                                <option value="">Select Color</option>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->colorID }}">{{ $color->color_name }}</option>
                                                @endforeach
                                            </select>
                                            @if(count($colors) > 0)
                                                <div class="mt-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="color-swatch" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $colors[0]->color_code }}; border: 1px solid #ddd;"></div>
                                                        <span class="ms-2">{{ $colors[0]->color_name }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Size</label>
                                            <select class="form-select" name="product_size" required>
                                                <option value="">Select Size</option>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="product_stock" min="0" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Product Image</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Variant</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Variant Modals - Generated with PHP -->
                @foreach($variants as $variant)
                <div class="modal fade" id="editVariantModal{{ $variant->product_variantID }}" tabindex="-1" aria-labelledby="editVariantModalLabel{{ $variant->product_variantID }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVariantModalLabel{{ $variant->product_variantID }}">Edit Variant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('products.variants.update', ['product' => $product->productID, 'variant' => $variant->product_variantID]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tone</label>
                                            <select class="form-select" name="toneID" required>
                                                <option value="">Select Tone</option>
                                                @foreach($tones as $tone)
                                                    <option value="{{ $tone->toneID }}" {{ $variant->toneID == $tone->toneID ? 'selected' : '' }}>
                                                        {{ $tone->tone_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="tone-swatch" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->tone->tone_code }}; border: 1px solid #ddd;"></div>
                                                    <span class="ms-2">{{ $variant->tone->tone_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Color</label>
                                            <select class="form-select" name="colorID" required>
                                                <option value="">Select Color</option>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->colorID }}" {{ $variant->colorID == $color->colorID ? 'selected' : '' }}>
                                                        {{ $color->color_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="color-swatch" style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $variant->color->color_code }}; border: 1px solid #ddd;"></div>
                                                    <span class="ms-2">{{ $variant->color->color_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Size</label>
                                            <select class="form-select" name="product_size" required>
                                                <option value="">Select Size</option>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                                    <option value="{{ $size }}" {{ $variant->product_size == $size ? 'selected' : '' }}>
                                                        {{ $size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="product_stock" min="0" value="{{ $variant->product_stock }}" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Current Image</label>
                                            <div class="current-image-container mb-2">
                                                <img src="{{ Storage::url($variant->product_image) }}" alt="Current Variant" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                            </div>
                                            <label class="form-label">Update Image (Optional)</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*">
                                            <small class="form-text text-muted">Leave empty to keep the current image</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Variant</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Delete Variant Confirmation Modals - Generated with PHP -->
                @foreach($variants as $variant)
                <div class="modal fade" id="deleteVariantModal{{ $variant->product_variantID }}" tabindex="-1" aria-labelledby="deleteVariantModalLabel{{ $variant->product_variantID }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteVariantModalLabel{{ $variant->product_variantID }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this variant? This action cannot be undone.</p>
                                <div class="d-flex align-items-center mt-3">
                                    <img src="{{ Storage::url($variant->product_image) }}" alt="Variant" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <strong>{{ $variant->tone->tone_name }} / {{ $variant->color->color_name }} / {{ $variant->product_size }}</strong>
                                        <div class="text-muted">Stock: {{ $variant->product_stock }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('products.variants.destroy', ['product' => $product->productID, 'variant' => $variant->product_variantID]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate discount percentage when base price or actual price changes
        const productPriceInput = document.getElementById('product_price');
        const actualPriceInput = document.getElementById('actual_price');
        const discountIndicator = document.getElementById('discount-indicator');
        const discountPercentage = document.getElementById('discount-percentage');

        function calculateDiscount() {
            const basePrice = parseFloat(productPriceInput.value) || 0;
            const actualPrice = parseFloat(actualPriceInput.value) || 0;
            
            if (basePrice > 0 && actualPrice > 0 && basePrice > actualPrice) {
                const discount = Math.round(((basePrice - actualPrice) / basePrice) * 100);
                discountPercentage.textContent = discount;
                discountIndicator.classList.remove('d-none');
            } else {
                discountIndicator.classList.add('d-none');
            }
        }

        productPriceInput.addEventListener('input', calculateDiscount);
        actualPriceInput.addEventListener('input', calculateDiscount);
    });
</script>
@endsection
