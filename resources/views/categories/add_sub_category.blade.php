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
    <h3 class="my-3" style="text-align:center; margin-right: 100px;">Add Subcategories for Main Category "{{ $mainCategory->Category_name }}"</h3>

    <div class="container d-flex justify-content-center align-items-start" style="min-height: 80vh; margin-top: 20px;">
        <div class="d-flex">

            <!-- Left Form Container - Shrinked size -->
            <div class="me-3" style="width: 100%; position: relative;">

                <div class="card p-4" style="position: relative; min-height: 300px;">
                    <!-- Move button inside card and place at top-right with margin -->
                    <!-- <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('categories.selectDefaultImage', $mainCategory->Category_id) }}" class="btn btn-default btn-sm">
                            Set Default Image
                        </a>
                    </div> -->

                    <form action="{{ route('categories.storeSub') }}" method="POST">
                        @csrf
                        <input type="hidden" name="main_category_id" value="{{ $mainCategory->Category_id }}">

                        <!-- Display any validation errors for subcategory name -->
                        @if($errors->has('subcategory_name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('subcategory_name') }}
                            </div>
                        @endif

                        <div id="subcategoriesContainer" class="mb-3">
                            @include('categories.partials.subcategory_block', [
                                'index' => 0,
                                'name' => '',
                                'image' => session('default_subcategory_image', 'https://qwiksale.com/images/default.png')
                            ])
                        </div>

                        <div class="d-flex justify-content-center gap-2" style="margin-top: 40px;">
                           <button type="button" class="btn btn-default" id="addSubcategoryBtn" onclick="addSubcategory()">+ Add More Subcategory</button>
<!-- <button type="submit" class="btn btn-default btn-sm">Save Subcategory</button> -->
<button type="submit" class="btn btn-default" name="saveAndCreateChild">Save & Create Child Category</button>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
let subcategoryCount = 1;

function addSubcategory() {
    const defaultImage = "{{ session('default_subcategory_image', 'https://qwiksale.com/images/default.png') }}";
    const container = document.getElementById('subcategoriesContainer');
    const addButton = document.getElementById('addSubcategoryBtn'); // Get the "Add More Subcategory" button

    // Show the button after clicking if necessary
    addButton.style.display = 'inline-block';

    const html = `
        <div class="border rounded p-3 mb-3 bg-light subcategory-block" data-index="${subcategoryCount}">
            <h6 class="text-muted">Subcategory ${subcategoryCount + 1}</h6>
            <input type="text" name="subcategories[${subcategoryCount}][name]" class="form-control subcategory-name" placeholder="Subcategory Name" required oninput="updatePreviews()">
            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="removeSubcategory(this)">Remove</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    subcategoryCount++;
    updatePreviews();
}

function removeSubcategory(button) {
    // Remove the subcategory block
    const subcategoryBlock = button.closest('.subcategory-block');
    subcategoryBlock.remove();

    // Show the "Add More Subcategory" button if there are no more subcategory blocks
    const remainingSubcategories = document.querySelectorAll('.subcategory-block');
    if (remainingSubcategories.length === 0) {
        document.getElementById('addSubcategoryBtn').style.display = 'block';
    }

    updatePreviews();
}

function updatePreviews() {
    const names = document.querySelectorAll('.subcategory-name');
    const images = document.querySelectorAll('.subcategory-image');

    // Desktop Preview - List of Subcategories
    const desktopList = document.getElementById('previewSubcategoriesDesktop');
    desktopList.innerHTML = '';
    names.forEach((input, index) => {
        const name = input.value || `Subcategory ${index + 1}`;
        desktopList.innerHTML += `<li>${name}</li>`;
    });

    // Mobile Preview - Grid of Subcategories inside phone frame
    const mobileGrid = document.getElementById('previewSubcategoriesMobile');
    mobileGrid.innerHTML = '';
    names.forEach((input, index) => {
        const name = input.value || `Subcategory ${index + 1}`;
        const image = images[index].value || 'https://qwiksale.com/images/default.png';

        mobileGrid.innerHTML += `
            <div style="width: 80px; text-align: center;">
                <img src="${image}" class="img-fluid" style="height: 50px; object-fit: contain;">
                <p class="mt-1" style="font-size: 12px;">${name}</p>
            </div>
        `;
    });
}

// Initial Preview Population
updatePreviews();




document.querySelector("form").addEventListener("submit", function (event) {
    let childCategoryNames = document.querySelectorAll(".childcategory-name");
    let nameValues = [];

    for (let input of childCategoryNames) {
        let name = input.value.trim();
        if (nameValues.includes(name)) {
            alert("Duplicate child category name found: " + name + ". Please rename it.");
            event.preventDefault(); // Prevent form submission
            return;
        }
        nameValues.push(name);
    }
});

</script>
@endsection
