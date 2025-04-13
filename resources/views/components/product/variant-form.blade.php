@props(['tones', 'colors', 'variant' => null, 'index' => null, 'isEdit' => false])

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tone</label>
        <select class="form-select tone-select" 
                name="{{ $isEdit ? 'toneID' : "variants[$index][toneID]" }}" 
                id="{{ $isEdit ? 'edit_toneID' : '' }}" required>
            <option value="">Select Tone</option>
            @foreach($tones as $tone)
                <option value="{{ $tone->toneID }}" 
                        data-tone-name="{{ $tone->tone_name }}" 
                        data-tone-code="{{ $tone->tone_code }}"
                        {{ $variant && $variant->toneID == $tone->toneID ? 'selected' : '' }}>
                    {{ $tone->tone_name }}
                </option>
            @endforeach
        </select>
        <div class="tone-indicator d-none mt-2">
            <div class="d-flex align-items-center">
                <div class="tone-swatch"></div>
                <span class="tone-name ms-2"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Color</label>
        <select class="form-select color-select" 
                name="{{ $isEdit ? 'colorID' : "variants[$index][colorID]" }}" 
                id="{{ $isEdit ? 'edit_colorID' : '' }}" required>
            <option value="">Select Color</option>
            @foreach($colors as $color)
                <option value="{{ $color->colorID }}" 
                        data-color-name="{{ $color->color_name }}" 
                        data-color-code="{{ $color->color_code }}"
                        {{ $variant && $variant->colorID == $color->colorID ? 'selected' : '' }}>
                    {{ $color->color_name }}
                </option>
            @endforeach
        </select>
        <div class="color-indicator d-none mt-2">
            <div class="d-flex align-items-center">
                <div class="color-swatch"></div>
                <span class="color-name ms-2"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Size</label>
        <select class="form-select" 
                name="{{ $isEdit ? 'product_size' : "variants[$index][product_size]" }}" 
                id="{{ $isEdit ? 'edit_product_size' : '' }}" required>
            <option value="">Select Size</option>
            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                <option value="{{ $size }}" {{ $variant && $variant->product_size == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stock</label>
        <input type="number" class="form-control" 
               name="{{ $isEdit ? 'product_stock' : "variants[$index][product_stock]" }}" 
               id="{{ $isEdit ? 'edit_product_stock' : '' }}"
               value="{{ $variant ? $variant->product_stock : '' }}"
               min="0" required>
    </div>
    @if($isEdit)
    <div class="col-12 mb-3">
        <label class="form-label">Current Image</label>
        <img id="current_variant_image" src="{{ $variant && $variant->product_image ? Storage::url($variant->product_image) : '' }}" 
             alt="Current Variant Image" class="img-thumbnail mb-2" style="max-width: 200px;">
        <label class="form-label">New Image (optional)</label>
        <input type="file" class="form-control" name="product_image" accept="image/*">
    </div>
    @else
    <div class="col-12">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" 
               name="variants[{{ $index }}][product_image]" 
               accept="image/*" required>
    </div>
    @endif
</div>