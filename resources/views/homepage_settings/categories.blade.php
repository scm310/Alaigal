@extends('admin_layouts.app')

@section('content')

<style>
    #categoriesTable {
    width: 80% !important;
    margin: auto;
}
.dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        margin-right:130px;
        margin-left:130px;
    }

</style>

<div class="card">
    <div class="card-header">
        <h4>Homepage Category Settings</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('homepage.categories.update') }}" method="POST" id="categoryForm">
            @csrf

          <div style="width: 90%; margin: auto; overflow-x: auto;">
    <table id="categoriesTable" class="table table-striped table-bordered mt-4 pt-4" style="width: 100%;">

                <thead class="bg-primary">
                <tr>
    <th scope="col" style="color:white; font-size:medium; text-align:center; width:1%; text-transform: capitalize;">S.No</th>
    <th scope="col" style="color:white; font-size:medium; text-align:center; width:2%; text-transform: capitalize;">Category Name</th>
    <th scope="col" style="color:white; font-size:medium; text-align:center; width:2%; text-transform: capitalize;">Category Image</th>
    <th scope="col" style="color:white; font-size:medium; text-align:center; width:1%; text-transform: capitalize;">Actions</th>
</tr>


                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                    <tr>
                        <td style="text-align:center;">{{ $index + 1 }}</td> <!-- Serial number -->
                        <td>{{ $category->Category_name }}</td>
                        <td class="text-center">
    <img src="{{ asset($category->Category_image) }}" 
         alt="{{ $category->Category_name }}" 
         class="category-img product-image"
         style="max-width: 100px; max-height: 100px; object-fit: cover; transition: transform 0.3s ease-in-out;" 
         onmouseover="this.style.transform='scale(2.5)'" 
         onmouseout="this.style.transform='scale(1)'">
</td>



                        <td class="text-center">
    <!-- Hidden input for unchecked state -->
    <input type="hidden" name="categories[{{ $category->Category_id }}]" value="0">
    <!-- Checkbox for checked state -->
    <input type="checkbox" name="categories[{{ $category->Category_id }}]" 
           value="1" {{ isset($homepageCategories[$category->Category_id]) && $homepageCategories[$category->Category_id] == 1 ? 'checked' : '' }}
           data-category-id="{{ $category->Category_id }}" class="update-category-checkbox larger-checkbox">
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Image Zoom Effect */
    .category-img {
        transition: transform 0.3s ease-in-out;
        width: 80px; /* Bigger image */
        height: auto;
    }
    .category-img:hover {
        transform: scale(1.9);
    }
    .larger-checkbox {
    transform: scale(1.5); /* Increases the size by 1.5 times */
    margin: 0; /* Adjusts the margin if necessary */
}

</style>

<!-- DataTable Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable for categories
        $('#categoriesTable').DataTable({
            "responsive": true,  // Responsive for mobile
            "pageLength": 10,    // Default rows per page
            "lengthMenu": [10, 25, 50, 100], // Options for rows per page
            "ordering": false,    // Enable sorting
            "searching": true,   // Enable search
            "info": true         // Show table info
        });

        // Checkbox validation: Max 7 categories
        $('.update-category-checkbox').on('change', function() {
            var selectedCount = $('.update-category-checkbox:checked').length;

            if (selectedCount > 7) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'You should not select more than 7 categories!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                this.checked = false; // Uncheck last selected checkbox
            }
        });
    });
</script>

<script>
document.querySelectorAll('.update-category-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var selectedCount = document.querySelectorAll('.update-category-checkbox:checked').length;
        var categoryId = this.getAttribute('data-category-id');
        var isChecked = this.checked ? 1 : 0;
        var checkboxElement = this; // Store reference to checkbox

        // If user selects more than 7 categories, show warning and uncheck
        if (selectedCount > 7) {
            Swal.fire({
                title: 'Warning!',
                text: 'You should not select more than 7 categories!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            this.checked = false; // Uncheck the last selected checkbox
            return; // Exit function if more than 7 categories are selected
        }

        if (!isChecked) {
            // SweetAlert Confirmation for Removing
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to remove this category from the homepage?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateCategory(categoryId, isChecked);
                } else {
                    checkboxElement.checked = true; // Re-check the checkbox if user cancels
                }
            });
        } else {
            updateCategory(categoryId, isChecked);
        }
    });
});

function updateCategory(categoryId, status) {
    var formData = new FormData();
    formData.append('categories[' + categoryId + ']', status);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('homepage.categories.update') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Parse JSON response
    .then(data => {
        if (data.success) {
            // Close any existing alert before showing a new one
            Swal.close();

            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                showConfirmButton: false, // Removes OK button
                timer: 2000, // Closes after 2 seconds
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong while updating the category.',
                icon: 'error',
                confirmButtonText: 'OK'
            }); 
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error); // Log error in console
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}




function updateCategory(categoryId, status) {
    var formData = new FormData();
    formData.append('categories[' + categoryId + ']', status);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('homepage.categories.update') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Parse JSON response
    .then(data => {
        if (data.success) {
            // Close any existing alert before showing a new one
            Swal.close();

            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                showConfirmButton: false, // Removes OK button
                timer: 2000, // Closes after 2 seconds
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong while updating the category.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error); // Log error in console
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}
</script>

@endsection
