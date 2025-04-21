@extends('admin.layout.sidenavbar')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<style>

    /* Center the form and reduce width */
    .upload-banner-card {
        max-width: 300px;
        margin: 0 auto;
        /* Center align */
    }

    /* Adjust image size */
    .banner-image {
        width: 120px;
        height: auto;
    }

    .banner {
        width: 300px;
        margin-left: 300px;
    }

    /* Hide sorting icons in table headers */
    table#complaintTable thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;

        text-align: center !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */


    .bg-primary {
        background-color: white !important;
    }


    #complaintTable {
        font-size: 12px;
        /* Adjust font size */
        width: 50% !important;
    }

    /* Hide sorting icons in table headers */


    /* Reduce button size */
    .btn-sm {
        padding: 3px 6px;
        font-size: 11px;
    }



    /* If the + icon is inside a button or span */
    .plus-icon {
        margin-right: 8px;
        /* Adjust spacing */
    }


    /* Header */
    .header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }


    /* Apply white background to the container */
    .banner-container {
        background-color: #fff;
        /* White background */
        padding: 20px;
        border-radius: 10px;
        /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Light shadow */
    }

    /* Make table background white */
    .table {
        background-color: #fff;
        margin-left: 215px;
    }

    /* Ensure form and content have a white background */
    .banner {
        background-color: #fff;
        padding: 20px;
    }

    .header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }


    /* Center modal content */
    .modal-dialog {
        max-width: 350px;
        /* Adjust width as needed */
        margin: auto;
    }

    /* Modal background overlay */
    .modal-backdrop {
        background: rgba(0, 0, 0, 0.5);
        /* Slight transparency */
    }

    /* Modal content */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Modal header */
    .modal-header {
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }


    /* Modal body */
    .modal-body {
        padding: 20px;
    }



    /* Form inputs */
    .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    /* Upload button */
    .btn-primary {
        background: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #0056b3;
    }
    .banner{
        margin-left:720px;
        width: 150px;
        height:40px;
        padding:9px;
    }



    .banner-img {
    width: auto;
    height: 80px;
    transform: translateX(30px);
    transition: transform 0.3s ease-in-out, scale 0.3s ease-in-out;
    cursor: pointer; /* Optional: Change cursor to indicate zoom */
}

.banner-img:hover {
    transform: translateX(30px) scale(1.5); /* Zoom effect */
}


    .btn-close {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    width: 1.5rem;
    height: 1.5rem;
    opacity: 0.5;
    margin-top: -11px;
}

.btn-close:hover {
    opacity: 0.8;
}

.delete-btn {
    background: none;
    border: none;
    color: red;
    font-size: 19px;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

@media screen and (max-width: 768px) {
    .upload-banner-card {
        max-width: 100%;
        margin: 0 auto;
    }

    .banner {
        width: 100%;
        margin-left: 0;
        text-align: center;
    }

    #complaintTable {
        font-size: 10px;
        width: 100% !important;
    }

    .modal-dialog {
        max-width: 90%;
        margin: auto;
    }

    .banner-img {
        width: 100%;
        height: auto;
        transform: translateX(0);
    }

    .banner-img:hover {
        transform: scale(1.2);
    }

    .table {
        margin-left: 0;
        width: 100%;
    }

    .banner-container {
        padding: 10px;
    }

    .btn-primary {
        width: 40%;
        margin-left:185px;
        margin-top:-8px;
    }

    .btn-close {
        font-size: 1rem;
        width: 1rem;
        height: 1rem;
    }

    .delete-btn {
        font-size: 16px;
    }
}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}


</style>



<div class="container mt-4 banner-container">
    <!-- <h2 class="text-center header">Upload Banner</h2> -->


    {{-- Success or Error Messages --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .small-swal {
            width: 300px !important;  /* Smaller width */
            font-size: 14px !important;  /* Smaller font size */
        }
        .swal2-title {
            font-size: 18px !important;  /* Smaller title font */
        }
        .swal2-content {
            font-size: 14px !important;  /* Smaller content font */
        }
        .swal2-popup .swal2-actions .swal2-confirm {
            font-size: 13px !important;
            padding: 6px 12px !important;
        }
    </style>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#866ec7',
            customClass: {
                popup: 'small-swal'  // Apply custom style
            }
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
            customClass: {
                popup: 'small-swal'  // Apply custom style
            }
        });
    </script>
    @endif





    {{-- Form for Banner Upload --}}

    <!-- Button to Open the Modal -->

    <!-- Modal -->
    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bannerModalLabel">Upload Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('header-setting.uploadBanner') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="banner" class="form-label">Choose Banner Image:</label>
                            <input type="file" name="banner" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-50" style="margin-left:78px;">Upload Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Required for Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    {{-- Display the Uploaded Banners --}}

{{-- Display the Uploaded Banners --}}
<h3 class="text-center mt-4 header">Uploaded Banners</h3>

<!-- Add Banner Button -->
<button type="button" class="btn btn-primary w-30 banner"
        data-bs-toggle="modal" data-bs-target="#bannerModal"
        id="addBannerBtn" @if ($bannerCount > 0) disabled @endif>
    Add Banner
</button>

<!-- Hidden Message (Appears if button is disabled) -->
<p id="banner-message" class="text-danger col-md-8"
       style="display: none; margin-top: -5px; font-size: 14px;transform: translateY(-30px);
    margin-left: 120px;
">
        You can only add one banner at a time. Please delete the existing banner first.
    </p>

<div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width:100%; overflow-x: auto;">
        <thead class="bg-light">
            <tr>
                <th>S.No</th>
                <th>Banner Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody style="background-color: #e7cfcf;">
            @forelse ($banners as $banner)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img src="{{ asset('storage/app/public/customer_banner/' . $banner->image) }}"
                         alt="Banner Image" class="banner-img">
                </td>
                <td>
                    {{-- Delete Form --}}
                    <form id="delete-form-{{ $banner->id }}"
                          action="{{ route('header-setting.deleteBanner', $banner->id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <!-- Delete Button -->
                        <button type="button" class="delete-btn" onclick="confirmDelete({{ $banner->id }})">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No banners uploaded yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- JavaScript to Show Message -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let addBannerBtn = document.getElementById("addBannerBtn");
        let bannerMessage = document.getElementById("banner-message");

        if (addBannerBtn.disabled) {
            bannerMessage.style.display = "block";  // Show message if button is disabled
        }
    });
</script>

</div>

<script>
    $(document).ready(function() {
        $('#complaintTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": false // Disable sorting
        });
    });
</script>

<!-- JavaScript Function -->
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(bannerId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#BE6CFD",
        cancelButtonColor: "#B2BEB5",
        confirmButtonText: "Yes, delete it!",
        customClass: {
            popup: "small-alert" // Applying custom class
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + bannerId).submit();
        }
    });
}

</script>

<style>
.small-alert {
    width: 400px !important;  /* Adjust width as needed */
    height: 300px !important; /* Adjust height as needed */
    font-size: 12px !important;
}
</style>
@endsection
