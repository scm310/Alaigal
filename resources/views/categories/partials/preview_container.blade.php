<div class="card p-3 bg-light preview-container" style="height: 100%; background: #f8f9fa;">
    <h5 class="text-center">Preview</h5>

    <!-- Desktop View -->
    <div class="border p-2 mb-3" style="background: white;">
        <h6 class="text-muted">Desktop View</h6>
        <img src="{{ asset($image ?? 'images/default.png') }}" id="previewImageDesktop" class="img-fluid" style="height: 150px; object-fit: contain;">
        <p class="mt-2" id="previewNameDesktop">{{ $name ?? 'Category Name' }}</p>
    </div>

    <!-- Mobile View -->
    <div class="border p-2 text-center" style="background: white;">
        <h6 class="text-muted">Mobile View</h6>
        <div style="border: 12px solid black; border-radius: 20px; width: 200px; height: 400px; margin: auto; overflow: hidden;">
            <div style="background: #f8f9fa; padding: 10px;">
                <img src="{{ asset($image ?? 'images/default.png') }}" id="previewImageMobile" class="img-fluid" style="height: 80px; object-fit: contain;">
                <p class="mt-2" id="previewNameMobile" style="font-size: 14px;">{{ $name ?? 'Category Name' }}</p>
            </div>
        </div>
    </div>
</div>
