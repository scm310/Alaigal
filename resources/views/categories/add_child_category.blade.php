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
    <h3 class="my-3" style="text-align:center;">Add Child Categories for "{{ $mainCategory->Category_name }}"</h3>
    <div class="container d-flex justify-content-center align-items-start" style="min-height: 80vh; margin-top: 20px;">
        <!-- Left Form Container -->
        <div style="width: 45%; position: relative;">
            <div class="card p-4">
                <!-- <div class="d-flex justify-content-end mb-2">
                    <a href="{{ route('categories.selectChildDefaultImage', ['main_category_id' => $mainCategory->Category_id, 'sub_category_id' => $subCategories->first()->id ?? 0]) }}" 
                       class="btn btn-default btn-sm">Select Default Image</a>
                </div> -->
                <form action="{{ route('categories.storeChildFromVendor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="main_category_id" value="{{ $mainCategory->Category_id }}">

                    <!-- Error Message Container -->
                    @if ($errors->any())
                        <div id="error-message-container" style="color: red; margin-bottom: 15px;">
                            <strong>Duplicate child category names found. Please rename them.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="childcategoriesContainer">
                        <div class="border rounded p-3 mb-3 bg-light childcategory-block">
                            <h6 class="text-muted">Child Category 1</h6>
                            <label>Subcategory</label>
                            <select name="childcategories[0][subcategory_id]" class="form-control subcategory-select" required>
                                <option value="">Select Subcategory</option>
                                @foreach($subCategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="childcategories[0][name]" class="form-control mt-2 childcategory-name" placeholder="Child Category Name" oninput="updatePreviews()" required>
                            <!-- <input type="text" name="childcategories[0][image]" class="form-control mt-2 childcategory-image" value="{{ session('default_childcategory_image', '/images/default.png') }}" readonly> -->
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-default" id="addChildCategoryBtn" onclick="addChildCategory()">+ Add More Child Category</button>
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let childCategoryCount = 1;

function addChildCategory() {
    const subcategories = @json($subCategories);
    const defaultImage = "{{ session('default_childcategory_image', '/images/default.png') }}";

    let options = '<option value="">Select Subcategory</option>';
    subcategories.forEach(subcat => {
        options += `<option value="${subcat.id}">${subcat.name}</option>`;
    });

    const html = `
        <div class="border rounded p-3 mb-3 bg-light childcategory-block">
            <h6 class="text-muted">Child Category ${childCategoryCount + 1}</h6>
            <label>Subcategory</label>
            <select name="childcategories[${childCategoryCount}][subcategory_id]" class="form-control subcategory-select" required>
                ${options}
            </select>
            <input type="text" name="childcategories[${childCategoryCount}][name]" class="form-control mt-2 childcategory-name" placeholder="Child Category Name" oninput="updatePreviews()" required>
            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="removeChildCategory(this)">Remove</button> <!-- Remove Button -->
        </div>
    `;
    document.getElementById('childcategoriesContainer').insertAdjacentHTML('beforeend', html);
    childCategoryCount++;

    // Hide Add More button after adding the first child category
    document.getElementById('addChildCategoryBtn').style.display = 'none';

    updatePreviews();
}

function removeChildCategory(button) {
    const childCategoryBlock = button.closest('.childcategory-block');
    childCategoryBlock.remove();

    // If no child categories left, show the Add More button again
    if (document.querySelectorAll('.childcategory-block').length === 0) {
        document.getElementById('addChildCategoryBtn').style.display = 'block';
    }

    updatePreviews();
}

function updatePreviews() {
    const names = document.querySelectorAll('.childcategory-name');
    const images = document.querySelectorAll('.childcategory-image');
    const subcategories = document.querySelectorAll('.subcategory-select');

    // Clear previews
    document.getElementById('previewChildCategoriesMobile').innerHTML = '';
    @foreach($subCategories as $subcategory)
        document.getElementById('desktopChildCategories_{{ $subcategory->id }}').innerHTML = '';
    @endforeach

    names.forEach((nameInput, index) => {
        const name = nameInput.value || `Child ${index + 1}`;
        const image = images[index].value || '/images/default.png';
        const subcategoryId = subcategories[index].value;

        if (subcategoryId) {
            document.getElementById('desktopChildCategories_' + subcategoryId).innerHTML += `
                <li>${name}</li>
            `;
        }

        document.getElementById('previewChildCategoriesMobile').innerHTML += `
            <div style="width: 45%; text-align: center;">
                <img src="${image}" class="img-fluid" style="height: 40px; object-fit: contain;">
                <p class="mt-1" style="font-size: 12px;">${name}</p>
            </div>
        `;
    });
}

// Initial Preview Load
updatePreviews();

// Validate Duplicate Child Categories
function validateDuplicateChildCategories() {
    let childCategories = [];
    let duplicateFound = false;
    let errorMessageContainer = document.getElementById('error-message-container');
    
    // Reset error message visibility before checking
    errorMessageContainer.style.display = 'none';

    document.querySelectorAll('.childcategory-block').forEach(block => {
        let subcategoryId = block.querySelector('.subcategory-select').value;
        let childCategoryName = block.querySelector('.childcategory-name').value.trim().toLowerCase();

        if (subcategoryId && childCategoryName) {
            let key = `${subcategoryId}-${childCategoryName}`;
            if (childCategories.includes(key)) {
                duplicateFound = true;
            }
            childCategories.push(key);
        }
    });

    // If duplicates are found, show the error message container and return false
    if (duplicateFound) {
        errorMessageContainer.style.display = 'block';
        return false;
    }

    return true;
}

// Add an event listener to form submission
document.querySelector('form').addEventListener('submit', function (event) {
    if (!validateDuplicateChildCategories()) {
        event.preventDefault(); // Prevent form submission if duplicates are found
    }
});
</script>
@endsection
