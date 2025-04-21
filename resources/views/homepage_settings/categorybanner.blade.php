@extends('admin_layouts.app')
<style>
    .btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}

    /* Change hover color of Cancel button to gray */
    .swal2-cancel:hover {
        background-color: gray !important;
        border-color: gray !important;
    }
      /* Center the image */
      .text-center {
        text-align: center;
    }

    /* Add hover effect with transition */
    .banner-img {
        transition: transform 0.3s ease-in-out;
    }

    .banner-img:hover {
        transform: scale(2.1); /* Slight zoom on hover */
    }

 
    .modal-backdrop {
    display: none !important; /* Completely hides the backdrop */
}

</style>

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-primary text-center">Category Banners</h2>

        <div class="text-center">

        
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="max-width: 500px;">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="max-width: 500px;">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
        </div>


        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label fw-bold">Select Category</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->Category_id }}">{{ $category->Category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label fw-bold">Upload Banner</label>
                    <input type="file" class="form-control" name="image" required>
                    <div class="mb-3  text-muted">
            <small>Note: Banner size should be <strong>1116x150 </strong> pixels.</small>
        </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit"  class="btn btn-default">Upload</button>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-4 mt-4">
        <h4 class="text-center text-secondary">Uploaded Banners</h4>
        <div class="table-responsive">
        <table id="categoriesTable" class="table table-striped table-bordered mt-4 pt-4" style="width: 100%;">


            <thead class="bg-primary">
                    <tr>
                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Category</th>
                    <th scope="col" rowspan="3" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Image</th>
                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>
                    </tr>
                </thead>
                <tbody>
        @php
            $groupedBanners = $banners->groupBy('category_id');
        @endphp

        @foreach($groupedBanners as $categoryId => $categoryBanners)
            <tr>
                <td rowspan="{{ count($categoryBanners) }}">{{ $loop->iteration }}</td>
                <td rowspan="{{ count($categoryBanners) }}">{{ $categoryBanners->first()->category->Category_name ?? 'N/A' }}</td>
                <td class="text-center">
                    <img src="{{ asset('storage/app/public/' . $categoryBanners[0]->banner) }}" 
                         class="img-thumbnail banner-img" 
                         width="190px" 
                         alt="Banner Image">
                </td>
                <td>
                    <!-- <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="{{ $categoryBanners[0]->id }}" data-bs-toggle="modal" data-bs-target="#editModal">  <i class="fas fa-edit"></i></button> -->
                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $categoryBanners[0]->id }}">  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>

            @foreach($categoryBanners->skip(1) as $banner)
                <tr>
                    <td>
                        <img src="{{ asset('storage/app/public/' . $banner->banner) }}"  class="img-thumbnail banner-img" 
                             width="190px" 
                             alt="Banner Image">
                    </td>
                    <td>
                       
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}">  <i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>


            </table>
        </div>
    </div>
</div>



<!-- Edit Banner Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBannerForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editBannerId">
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Upload New Banner</label>
                        <input type="file" class="form-control" id="editImage" name="image" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function() {
                let bannerId = this.getAttribute("data-id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won’t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "rgb(144, 49, 212)", // Purple color for Confirm button
                    cancelButtonColor: "rgb(144, 49, 212)",  // Default Purple color for Cancel button
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/banners/${bannerId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                _method: "DELETE"
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Deleted!", "Your banner has been deleted.", "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        }).catch(error => {
                            Swal.fire("Error!", "Failed to delete.", "error");
                        });
                    }
                });
            });
        });
    });
</script>



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







@endsection

