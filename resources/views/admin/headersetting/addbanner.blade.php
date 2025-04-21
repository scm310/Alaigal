@extends('admin.layout.sidenavbar')

@section('content')

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<style>


@media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: block; /* Ensure it's visible */
        text-align: center; /* Center align for better mobile view */
        margin-bottom: 10px; /* Add some spacing */
    }
}


.banner-img {
        width: 100px; /* Set initial size */
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img:hover {
        transform: scale(1.8); /* Zoom in on hover */
    }
</style>

<style>
    @media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    h3, h4.card-title {
        font-size: 1.5rem;
        text-align: center;
        margin: 0;
    }

    h6 {
        font-weight: 700;
        margin-left: 0;
        transform: translateY(20px);
        font-size: 1rem;
    }

    /* Make the table scrollable horizontally on small screens */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Adjust table headers and cells for mobile */
    .table th, .table td {
        font-size: 0.85rem;  /* Reduce font size */
        padding: 8px;  /* Reduce padding */
        text-align: center;
        word-wrap: break-word; /* Allow word wrapping to prevent text overflow */
    }

    /* Make the actions buttons in the table more compact */
    .table td a, .table td button {
        font-size: 0.85rem;
        padding: 5px;
        margin-right: 5px;
    }

    /* Reduce card padding for better space management */
    .card-body {
        padding: 10px;
    }

    /* Adjust the table header font size for mobile */
    .table th {
        font-size: 0.9rem;
        padding: 10px;
    }

    /* Adjust the modal table content for mobile screens */
    .modal-body table {
        font-size: 0.85rem;
    }

    /* Make pagination and search icons responsive */
    .dataTables_wrapper .dataTables_length {
        float: left;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_paginate {
        float: right;
    }

    /* Adjust the buttons to be smaller on mobile */
    .btn {
        font-size: 0.85rem;
        padding: 5px 10px;
    }

    /* Reduce the spacing between table rows for a tighter layout */
    .table tbody tr {
        padding: 5px;
    }

    /* Ensure text content does not overflow */
    .scrollable-content {
        max-height: 100px;
        overflow-y: auto;
    }

    /* Remove unnecessary margins from card header */
    .card-header {
        padding: 10px 15px;
    }

    /* Adjust the layout of the room actions in mobile */
    .table td {
        white-space: nowrap; /* Ensure that buttons are not broken into multiple lines */
    }
}
/* Hide sorting icons in table headers */
table#complaintTable thead th {
    background-image: none !important; /* Remove the sort icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Remove sorting icons from table headers */
#complaintTable thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#complaintTable thead .sorting,
#complaintTable thead .sorting_asc,
#complaintTable thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#complaintTable thead .sorting:after,
#complaintTable thead .sorting:before,
#complaintTable thead .sorting_asc:after,
#complaintTable thead .sorting_asc:before,
#complaintTable thead .sorting_desc:after,
#complaintTable thead .sorting_desc:before {
    display: none !important;
}



.banner-img {
    width: 100px;  /* Set a fixed width */
    height: auto;  /* Maintain aspect ratio */
    max-height: 80px; /* Prevent excessive height */
    display: block; /* Ensure proper spacing */
    margin: auto; /* Center the image */
    object-fit: contain; /* Ensure full image is visible without stretching */
}

.form-control {
        border: 1px solid #ced4da;
        outline: none;
        transition: all 0.3s ease-in-out;
    }


    .bg-primary {
    background-color:white !important;
}





@media (max-width: 768px) {
    .banner-img {
        width: 80px;  /* Reduce width for mobile */
        max-height: 60px;  /* Adjust height accordingly */
    }
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

.alert {
    width: 31%;
    margin-left: 314px;
    position: relative;
}

/* Make it responsive for smaller screens */
@media (max-width: 768px) {
    .alert {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-close {
        font-size: 1.2rem;
        width: 1.2rem;
        height: 1.2rem;
    }

    .alert-dismissible .btn-close {
        top: 5px;
        right: 10px;
        padding: 0.5rem;
    }
}

@media (max-width: 480px) {
    .alert {
        width: 102%;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-close {
        font-size: 1rem;
        width: 1rem;
        height: 1rem;
    }

    .alert-dismissible .btn-close {
        top: 8px;
        right: 8px;
        padding: 0.4rem;
    }
}

 /* Main Container */
 .container-wrapper {
        width: 95%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
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
    button {
    border: none;  /* Removes the border */
    background: none;  /* Removes background */
    outline: none;  /* Prevents focus outline */
    padding: 0; /* Removes padding if unnecessary */
    cursor: pointer; /* Keeps it clickable */
}

.dataTables_filter {
    display: none !important;
}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}

</style>






<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Add Banner
   
    </div>


<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000 // Auto close after 3 seconds
        });
    </script>
@endif



<!-- Modal for Uploading Banner -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bannerModalLabel">Upload Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="banner" class="form-label">Choose Banner Image</label>
            <input type="file" class="form-control" id="banner" name="banner" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success" style="background-color:#866EC7;">Upload Banner</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
        <div class="card-body" style="text-align:center;" >
        <div class="d-flex justify-content-end mb-3 ">
        <button type="button" class="btn" style="background-color: #866ec7; color: white;" data-bs-toggle="modal" data-bs-target="#bannerModal">
    Upload Banner
</button>

</div>

            <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width:80%;">
            <thead>
                <tr>
                    <th style="text-align:center;">S.No</th>
                    <th style="text-align:center;">Banner Image</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
                @foreach($banners as $banner)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('storage/app/public/banners/' . $banner->banner_image) }}" alt="Banner Image" class="banner-img">
                    </td>
                    <td>


<!-- Delete Form -->
<form id="delete-form-{{ $banner->banner_id }}" action="{{ route('admin.banner.delete', $banner->banner_id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmDelete({{ $banner->banner_id }})">
        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
    </button>
</form>



                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>






<script>
    new DataTable('#complaintTable');
    
    $(document).ready(function () {
        $('#complaintTable').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: -1 // Last column for the "+" icon
                }
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,
                    targets: -1 // Targets the last column for mobile "+" icon
                }
            ],
            paging: true,
            pageLength: 10,
            searching: false, // Removes the search box
            language: {
                lengthMenu: "Show MENU entries"
            }
        });
    });
</script>


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










