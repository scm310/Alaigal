<div class="border rounded p-3 mb-3 bg-light subcategory-block" data-index="{{ $index }}">
    <h6 class="text-muted">Subcategory {{ $index + 1 }}</h6>

    <div class="mb-2">
        <label class="form-label">Subcategory Name</label>
        <input type="text" name="subcategories[{{ $index }}][name]" class="form-control subcategory-name" value="{{ $name }}" required oninput="updatePreviews()">
        @error("subcategories.$index.name")
        <small class="text-danger">{{ $message }}</small>
    @enderror
    </div>

    <!-- <div class="mb-2">
        <label class="form-label">Subcategory Image</label>
        <input type="text" class="form-control subcategory-image" name="subcategories[{{ $index }}][image]" value="{{ asset($image) }}" readonly>
    </div> -->
</div>
