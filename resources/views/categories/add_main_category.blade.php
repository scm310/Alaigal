@extends('admin_layouts.app')

<style>
.btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}

/* Styling for btn-secondary */
.btn-secondary {
    background-color: #853ede !important; /* Default Bootstrap gray */
    color: white !important;
    border-color: #853ede !important;
}

/* Hover effect for btn-secondary */
.btn-secondary:hover {
    background-color: gray !important;
    color: white !important;
}
</style>
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@section('content')
 <div class="card p-3 mb-3">
 <div class="container d-flex justify-content-center align-items-start" style="min-height: 90vh; min-width: 90vh;margin-top: 20px;">

    <div class="card p-4" style="width: 50%;">
        <h2 class="my-3 text-center">Add Main Category</h2>
       
        <form action="{{ route('categories.storeMainCategory') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="Category_name" class="form-label">Main Category Name</label>
        <input type="text" class="form-control @error('Category_name') is-invalid @enderror" 
               name="Category_name" id="Category_name" required oninput="updatePreviewMainCategory()" value="{{ old('Category_name') }}">
        @error('Category_name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="Category_image" class="form-label">Main Category Image</label>
        <input type="file" class="form-control @error('Category_image') is-invalid @enderror" 
               name="Category_image" id="Category_image" accept="image/jpeg,image/png,image/jpg" required onchange="previewMainImage(event)">
        <small class="text-muted">Allowed: JPG, PNG, JPEG | Max Size: 150KB</small>
        @error('Category_image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-center gap-2">
        <!-- <button type="submit" class="btn btn-default" name="save">Save Main Category</button> -->
        <button type="submit" class="btn btn-default" name="saveAndCreateSub">Save & Create Subcategory</button>
    </div>
</form>



        </div>

    </div>
</div>

<script>
    function updatePreviewMainCategory() {
        const name = document.getElementById('Category_name').value || 'Category Name';
        document.getElementById('previewMainCategoryNameDesktop').innerText = name;
        document.getElementById('previewMainCategoryNameMobile').innerText = name;
    }

    function previewMainImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewMainImageDesktop').src = e.target.result;
                document.getElementById('previewMainImageMobile').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
