<div class="modal fade" id="variantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="variantForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tone</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select tone-select" name="toneID" id="toneID" required>
                                <option value="">Select Tone</option>
                                @foreach($tones as $tone)
                                    <option value="{{ $tone->toneID }}" 
                                            data-tone="{{ $tone->tone_code }}">
                                        {{ $tone->tone_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="tone-preview rounded-circle border" style="width: 30px; height: 30px;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select color-select" name="colorID" id="colorID" required>
                                <option value="">Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->colorID }}" 
                                            data-color="{{ $color->color_code }}">
                                        {{ $color->color_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="color-preview rounded-circle border" style="width: 30px; height: 30px;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Size</label>
                        <select class="form-select" name="product_size" id="product_size" required>
                            <option value="">Select Size</option>
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="product_stock" 
                               id="product_stock" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="product_image" 
                               accept="image/*">
                        <small class="text-muted">Leave empty to keep existing image</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="variantForm" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update color/tone previews
    $('.tone-select, .color-select').change(function() {
        const option = $(this).find('option:selected');
        const preview = $(this).next('.color-preview');
        preview.css('background-color', option.data('color') || option.data('tone'));
    });
});
</script>
@endpush