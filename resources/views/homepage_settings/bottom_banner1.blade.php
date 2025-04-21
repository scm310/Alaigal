@extends('admin_layouts.app')

@section('content')

<style>

.content-wrapper {
    background-color: white;
}
            .upload-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .img-thumbnail {
      margin-left:110px;
    transition: transform 0.3s ease-in-out; /* Smooth transition */
    cursor: pointer; /* Change cursor to pointer on hover */
}

.img-thumbnail:hover {
    transform: scale(1.8); /* Zoom in effect */
}


.btn-primary{
margin-left:75px;
}
</style>
<div class="container mt-5">
<h4 class="mb-3">Upload Bottom Banner</h4>

@if(session('success'))
    <div id="successMessage" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<style>
    /* Centering the success message */
    #successMessage {
        position: fixed;  /* Fixed position so it stays in place while scrolling */
        left: 50%;        /* Horizontal center */
        transform: translate(-50%, -50%);  /* Adjust for exact centering */
        z-index: 9999;    /* Ensure it's on top of other content */
        width: 80%;       /* You can adjust the width as needed */
        max-width: 400px; /* Set a max width for the alert */
        text-align: center; /* Center the text inside the alert */
    }
</style>

<script>
    // Check if the success message exists
    if (document.getElementById('successMessage')) {
        // Set a timeout to hide the message after 3 seconds (3000 milliseconds)
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    }
</script>

    <div class="row">
        <!-- Form Column -->
        <div class="col-md-4">
    <div class="upload-container" style="margin-left:-50px;">
        <h5 class="text-center mb-3">Select Banner Images</h5>
        <form action="{{ route('bottom_banners.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <!-- Centering the button -->
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn w-50" style="background-color: #853ede; border-color: #853ede; color:#fff;">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>


        <!-- Table Column -->
        <div class="col-md-8" style="margin-top:-75px;">
            <h4 class="mt-4 " style="margin-left:200px;">Uploaded Bottom Banners</h4>
            <table id="categoriesTable" class="table table-striped table-bordered mt-4 pt-4" style="width: 100%;" >
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th style="width: 5%;">S.No</th>
                        <th style="width: 20%;">Image</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners2 as $banner)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                            <img src="{{ asset('storage/app/public/bottombanner1/' . $banner->image) }}" 
                             alt="Banner Image" width="150" height="100" class="img-thumbnail">

                            </td>
                            <td>
    <form action="{{ route('bottom_banners1.delete', $banner->id) }}" method="POST" id="delete-form-{{ $banner->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $banner->id }})">
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
</div>


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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(bannerId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#853ede',  // Changed Confirm button color
            cancelButtonColor: '#853ede',   // Set Cancel button default color (Grey)
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            customClass: {
                cancelButton: 'custom-cancel-button' // Custom class for Cancel button hover effect
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + bannerId).submit();
            }
        });
    }
</script>

<style>
    /* Custom hover effect for cancel button */
    .custom-cancel-button:hover {
        background-color: #b0b0b0 !important; /* Lighter grey on hover */
        color: white !important;
    }
</style>


@endsection
