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
                <td>{{ $variant->tone->tone_name }}</td>
                <td>{{ $variant->color->color_name }}</td>
                <td>{{ $variant->product_size }}</td>
                <td>{{ $variant->product_stock }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary edit-variant me-2" 
                            data-variant-id="{{ $variant->product_variantID }}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-danger delete-variant" 
                            data-variant-id="{{ $variant->product_variantID }}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
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