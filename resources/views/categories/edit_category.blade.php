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
@section('content')
<div class="card p-3 mb-3">
    <div class="container">
        <h2 class="card-title text-center">Edit Main Category - {{ $category->Category_name }}</h2><br>
        
        <!-- Show error message if exists -->
  
        
        <form action="{{ route('categories.update', $category->Category_id) }}" method="POST" enctype="multipart/form-data" id="categoryForm">
            @csrf

            <div class="card" style="max-width: 600px; margin: auto;">
                <div class="card-body">
                    <h5 class="card-title text-center">Edit Category</h5>

                    <!-- Main Category Name -->
                    <div class="form-group mb-3">
                        <label>Main Category Name</label>
                        <input type="text" name="Category_name" value="{{ $category->Category_name }}" class="form-control">
                    </div>

                    <!-- Main Category Image -->
                    <div class="form-group mb-3">
                        <label>Main Category Image (Optional)</label>
                        <input type="file" name="Category_image" class="form-control">
                        @if($category->Category_image)
                            <img src="{{ asset($category->Category_image) }}" class="mt-2" style="height: 60px;">
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-btn btn-default">Save Category</button>
                    </div>
                </div>
            </div>

            <!-- Existing Subcategories and Child Categories -->
            <hr>
            <h4 class="card-title text-center">Subcategories & Child Categories</h4>
            <div class="container" style="max-width: 600px; margin: auto;">
                <div id="existingSubcategoriesContainer">
                    @foreach($category->subcategories as $subcategory)
                        <div class="border p-3 mb-3 bg-light">
                            <h6 class="text-muted">Subcategory: {{ $subcategory->name }}</h6>
                            <div class="ms-3">
                                <ul>
                                    @forelse($subcategory->childCategories as $child)
                                        <li>{{ $child->name }}</li>
                                    @empty
                                        <li>No Child Categories</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Add New Subcategory Section -->
            <hr>
            <h4 class="card-title text-center">Add New Subcategories & Child Categories</h4><br>

            @if ($errors->any())
    <div class="alert alert-danger d-flex justify-content-between align-items-center" style="width: 600px; margin: 0 auto;" role="alert">
        <ul class="mb-0 me-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <!-- Close Button (Icon) -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif<br>



            <div class="container" style="max-width: 600px; margin: auto;">
                <div id="newSubcategoriesContainer" class="card">
                    <div class="card-body">
                        <!-- First block shown by default -->
                        <div class="border p-3 mb-3 bg-light subcategory-block">
                            <h6>New Subcategory 1</h6>
                            <input type="text" name="new_subcategories[0][name]" class="form-control mb-2" placeholder="Subcategory Name" required>

                            <div class="childcategoriesContainer">
                                <h6>Child Categories</h6>
                                <div class="border p-2 bg-white mb-2">
                                    <input type="text" name="new_subcategories[0][childcategories][0][name]" class="form-control" placeholder="Child Category Name" required>
                                </div>
                            </div>

                            <button type="button" class="btn btn-btn btn-default" onclick="addChildCategory(this, 0)">+ Add More Child Category</button>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="text-center">
                <button type="button" class="btn btn-btn btn-default mb-3" onclick="addSubcategory()">+ Add More Subcategory</button>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-btn btn-default">Update Category</button>
            </div>
        </form>
    </div>
</div>
<div id="newSubcategoriesContainer">
    <!-- Subcategory template -->
</div>



<script>
let subcategoryCount = 1;

function addSubcategory() {
    const container = document.getElementById('newSubcategoriesContainer');

    const subcategoryHTML = `
        <div class="border p-3 mb-3 bg-light subcategory-block">
            <h6>New Subcategory ${subcategoryCount + 1}</h6>
            <input type="text" name="new_subcategories[${subcategoryCount}][name]" class="form-control mb-2" placeholder="Subcategory Name" required>

            <div class="childcategoriesContainer">
                <h6>Child Categories</h6>
                <div class="border p-2 bg-white mb-2">
                    <input type="text" name="new_subcategories[${subcategoryCount}][childcategories][0][name]" class="form-control" placeholder="Child Category Name" required>
                </div>
            </div>

            <button type="button" class="btn btn-btn btn-default" onclick="addChildCategory(this, ${subcategoryCount})">+ Add More Child Category</button>
            <button type="button" class="btn btn-btn btn-secondary" onclick="removeSubcategory(this)">Remove Subcategory</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', subcategoryHTML);
    subcategoryCount++;
}

function addChildCategory(button, subcategoryIndex) {
    const container = button.previousElementSibling;

    const childCount = container.querySelectorAll('.border').length;

    const childHTML = `
        <div class="border p-2 bg-white mb-2">
            <input type="text" name="new_subcategories[${subcategoryIndex}][childcategories][${childCount}][name]" class="form-control" placeholder="Child Category Name" required>
            <button type="button" class="btn btn-btn btn-secondary   mt-1" onclick="removeChildCategory(this)">Remove Child Category</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', childHTML);
}

function removeSubcategory(button) {
    button.closest('.subcategory-block').remove();
}

function removeChildCategory(button) {
    button.closest('.border').remove();
}
</script>

@endsection
