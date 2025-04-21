@extends('admin_layouts.app')
<style>
    .swal2-cancel:hover {
        background-color: gray !important;
        border-color: gray !important;
    }

    /* Apply this to the image element */
.testimonial-image {
    transition: transform 0.3s ease-in-out; /* Smooth transition when hovering */
}

/* Hover effect */
.testimonial-image:hover {
    transform: scale(2.1);  /* Scale the image to 2.1 times its original size */
    z-index: 10;  /* Ensures the image appears above other elements when scaled */
}
.btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}

</style>
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1>Manage Bottom Banners</h1>

        {{-- Display Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 400px; margin: 0 auto;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Form to Upload Bottom Banner Image --}}
        <div class="d-flex justify-content-center mt-4">
            <form action="{{ route('bottom_banners.store') }}" method="POST" enctype="multipart/form-data" 
                  class="p-4 border rounded shadow bg-white" style="width: 400px;">
                @csrf

                <h4 class="mb-3 text-center">Upload Bottom Banner</h4>

                {{-- Image Upload Field --}}
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Banner Image:</label>
                    <input type="file" name="image" id="image" class="form-control border-primary shadow-sm" required>
                </div>

                {{-- Banner Size Note --}}
        <div class="mb-3 text-center text-muted">
            <small>Note: Banner size should be <strong>546x200</strong> pixels.</small>
        </div>

                {{-- Submit Button --}}
                <div class="text-center">
                    <button type="submit"class="btn btn-default px-4 py-2 fw-bold">
                        <i class="fas fa-upload me-2"></i> Upload Banner
                    </button>
                </div>
            </form>
        </div>

        <hr>

        {{-- Display Existing Banners in a Table --}}
        <h2>Existing Banners</h2>
        <table id="categoriesTable" class="table table-striped table-bordered mt-4 pt-4" style="width: 100%;">

<thead class="bg-primary">
                <tr>
                  <th scope="col" style="color:white; font-size:medium; text-align:center; width:1%; text-transform: capitalize;">S.No</th>
                  <th scope="col" style="color:white; font-size:medium; text-align:center; width:1%; text-transform: capitalize;">Image</th>
                  <th scope="col" style="color:white; font-size:medium; text-align:center; width:1%; text-transform: capitalize;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $index => $banner) <!-- Add $index to get the serial number -->
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                        <td>
    <img src="{{ asset('storage/app/public/' . $banner->image) }}" class="testimonial-image" width="100">
</td>

                        <td>
                            <!-- Delete Form with SweetAlert Trigger -->
                            <form action="{{ route('bottom_banners.destroy', $banner->id) }}" method="POST" id="deleteForm-{{ $banner->id }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $banner->id }})">
                                    <i class="fas fa-trash me-2"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(bannerId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "rgb(144, 49, 212)", // Purple color for Confirm button
            cancelButtonColor: "rgb(144, 49, 212)",  // Default Purple color for Cancel button
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if user confirms
                document.getElementById('deleteForm-' + bannerId).submit();
            }
        });
    }
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
