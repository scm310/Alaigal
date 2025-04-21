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
<div class="container">
    <h2 class="my-3">Manage Categories</h2>

    <!-- Top bar with Create button on the right -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="{{ route('categories.createMain') }}" class="btn btn-default">+ Create Category</a>
    </div>

    <!-- Filters inside a styled card like Products page -->
    <div class="card p-3 mb-3">
        <form method="GET" action="{{ route('categories.index') }}" class="d-flex align-items-center gap-2">
            <select name="mainCategory" id="mainCategory" class="form-control">
                <option value="">Select Main Category</option>
                @foreach($mainCategories as $category)
                    <option value="{{ $category->Category_id }}" {{ request('mainCategory') == $category->Category_id ? 'selected' : '' }}>
                        {{ $category->Category_name }}
                    </option>
                @endforeach
            </select>

            <select name="subCategory" id="subCategory" class="form-control">
                <option value="">Select Sub Category</option>
            </select>

            <select name="childCategory" id="childCategory" class="form-control">
                <option value="">Select Child Category</option>
            </select>

            <button type="submit" class="btn btn-default">Filter</button>
            <a href="{{ route('categories.refreshFilters') }}" class="btn btn-secondary">Refresh</a>
        </form>
    </div>

    <!-- Table Styled like Products page -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" style="width: 80%; margin: auto;">
                <thead style="background-color: #D6B8B7; color: #4D2C2C;">
                    <tr>
                        <th style="width: 3%">S.No</th>
                        <th style="width: 20%">Main Category</th>
                        <th style="width: 35%">Sub Categories</th>
                        <th style="width: 5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->Category_name }}</td>
                            <td>
                                @foreach($category->subcategories as $subcategory)
                                    <div class="subcategory-toggle" data-subcategory-id="{{ $subcategory->id }}" style="cursor: pointer; text-decoration: underline;" title="Click to view Child Categories">
                                        <strong>{{ $subcategory->name }}</strong>
                                    </div>
                                    <div id="childcategories-{{ $subcategory->id }}" class="childcategories-container" style="display:none; padding-left:20px;">
                                        <ul class="list-unstyled">
                                            @forelse($subcategory->childcategories as $child)
                                                <li>- {{ $child->name }}</li>
                                            @empty
                                                <li>No child categories available.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="background: linear-gradient(270deg, #9055fd 0%, #c4a5fe 100%);">
                                        <li>
                                            <a class="dropdown-item text-white" href="{{ route('categories.edit', $category->Category_id) }}">
                                                <i class="fas fa-edit" style="color: blue;"></i> Edit
                                            </a>
                                        </li>
                                        <li>
    <button type="button" class="dropdown-item text-white delete-btn" data-id="{{ $category->Category_id }}">
        <i class="fas fa-trash" style="color: red;"></i> Delete
    </button>
    <form action="{{ route('categories.delete', $category->Category_id) }}" method="POST" class="delete-form-{{ $category->Category_id }}" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('mainCategory').addEventListener('change', function() {
    fetch(`/categories/subcategories/${this.value}`)
    .then(res => res.json())
    .then(data => populateDropdown('subCategory', data));
});

document.getElementById('subCategory').addEventListener('change', function() {
    fetch(`/categories/childcategories/${this.value}`)
    .then(res => res.json())
    .then(data => populateDropdown('childCategory', data));
});

function populateDropdown(id, data) {
    let dropdown = document.getElementById(id);
    dropdown.innerHTML = '<option value="">Select</option>';
    data.forEach(item => {
        dropdown.innerHTML += `<option value="${item.id}">${item.name}</option>`;
    });
}

document.querySelectorAll('.subcategory-toggle').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
        const subcategoryId = this.getAttribute('data-subcategory-id');
        const childContainer = document.getElementById('childcategories-' + subcategoryId);
        if (childContainer.style.display === 'none') {
            childContainer.style.display = 'block';
        } else {
            childContainer.style.display = 'none';
        }
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let categoryId = this.getAttribute("data-id"); // Get category ID
                let form = document.querySelector(".delete-form-" + categoryId); // Get the form

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#853ede",
                    cancelButtonColor: "#853ede",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    customClass: {
                        cancelButton: "swal-cancel-btn"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form only if confirmed
                    }
                });
            });
        });
    });
</script>

<style>
    .swal-cancel-btn:hover {
        background-color: gray !important;
        color: white !important;
    }
</style>


@endsection