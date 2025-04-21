@extends('admin.layout.sidenavbar')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Add Bootstrap JS (Only if not included already) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>

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
    .card{
      padding:10px;
    }




@media (max-width: 360px) {
   .card{
    margin-top:70px;
    width: 350px;
   }

    .card-header {
        padding: 10px;
        font-size: 16px; /* Reduce font size for mobile */
        text-align: center;
    }

    .card-header h2 {
        font-size: 20px; /* Slightly smaller text */
    }
}



    @media (max-width: 412px) {
        .card{
    margin-top:70px;
   }


.card-header {
    text-align: center; /* Keep text centered */
    padding: 12px;      /* Adjust padding */
    font-size: 18px;    /* Make text readable */
    border-radius: 10px 10px 0 0; /* Smooth rounded corners */
}

.card-header h2 {
    font-size: 22px; /* Slightly larger font for visibility */
}
}


/* Hide sorting icons in table headers */
table#complaintTable thead th {
    background-image: none !important; /* Remove the sort icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target the DataTables sorting classes */
table#complaintTable thead .sorting:after,
table#complaintTable thead .sorting:before,
table#complaintTable thead .sorting_asc:after,
table#complaintTable thead .sorting_asc:before,
table#complaintTable thead .sorting_desc:after,
table#complaintTable thead .sorting_desc:before {
    display: none !important; /* Hide the sorting arrows */
}
.logo-img {
        max-width: 80px;  /* Adjust the width */
        max-height: 50px; /* Adjust the height */
        display: block;
        margin: 0 auto; /* Center the image */
    }
    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before {
    content: '+' !important;
    font-size: 18px;
    color: #007bff; /* Bootstrap blue */
    font-weight: bold;
    display: inline-block;
    margin-right: 10px;
}

button {
    border: none;  /* Removes the border */
    background: none;  /* Removes background */
    outline: none;  /* Prevents focus outline */
    padding: 0; /* Removes padding if unnecessary */
    cursor: pointer; /* Keeps it clickable */
}
#uploadLogoBtn {
    position: absolute;
    right: 20px; /* Moves the button to the right */
    top: -50px; /* Moves the button slightly above the table */
    background-color: #866ec7;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
}

#uploadLogoBtn {
    position: absolute;
    right: 20px; /* Moves the button to the right */
    top: 95px; /* Moves the button slightly above the table */
    background-color: #866ec7;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
}


@media (max-width: 768px) {
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        display: block;
    }

    table {
        width: 100%;
        table-layout: auto;
        word-wrap: break-word;
        white-space: normal;
    }

    th, td {
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    /* Ensure text breaks properly */
    td {
        max-width: 150px; /* Adjust this as needed */
        white-space: normal !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Reduce font size and padding for better spacing */
    table#complaintTable th,
    table#complaintTable td {
        font-size: 14px;
        padding: 8px;
    }

    /* Ensure images do not cause overflow */
    .logo-img {
        max-width: 60px;
        height: auto;
    }

}


.form-control{
    border: 1px solid black;
}

@media (max-width: 576px) { /* Apply styles only for mobile screens */
        #errorMessage {
            margin-top: 20px !important; /* Reduce top margin for small screens */

        }
    }

    table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}

</style>


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

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000 // Auto close after 3 seconds
        });
    </script>
@endif


<!-- Error Message when logo already exists -->

<div class="container-wrapper mt-5 position-relative">
    <!-- Header -->
    <div class="header">Add Logo</div>

    <div class="container d-flex justify-content-center">
        <div id="errorMessage" class="alert alert-warning alert-dismissible fade show text-center" role="alert"
             style="display: none;">
            To add a new logo and title, please delete the previous data first.
        </div>
    </div>




    <button type="button" class="btn" id="uploadLogoBtn"
    style="background-color: #866ec7; color: white;"
    data-bs-toggle="modal" data-bs-target="#logoModal">
    Upload Logo
</button>



    <div class="table-responsive mt-5">
        <table class="table table-striped table-bordered dt-responsive nowrap" width="100%" id="complaintTable">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Logo Image</th>
                    <th>Website Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
                @forelse($logos as $logo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/app/public/logos/' . $logo->logo) }}" alt="Logo Image" class="logo-img">
                        </td>
                        <td>{{ $logo->title }}</td>
                        <td>
                        <form id="delete-logo-form-{{ $logo->id }}" action="{{ route('admin.logo.delete', $logo->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="border-0 bg-transparent delete-logo-btn" data-id="{{ $logo->id }}">
        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
    </button>
</form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


    @if($logos->isEmpty())
    <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoModalLabel">Upload Logo & Title</h5>
              <button type="button" class="btn-close1" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
              <form id="uploadForm" action="{{ route('admin.header.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="logo" class="form-label">Upload Logo</label>
                  <input type="file" class="form-control" id="logo" name="logo" required>
                </div>
                <div class="mb-3">
                  <label for="title" class="form-label">Website Title</label>
                  <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success" style="background-color: #866EC7;">Upload</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
@endif

<!-- JS to Show Message Instead of Modal -->
<script>
    document.getElementById('uploadLogoBtn').addEventListener('click', function(event) {
        @if(!$logos->isEmpty())
            // If logo already exists, show the warning message instead of the modal
            document.getElementById('errorMessage').style.display = 'block';
        @else
            // Show the modal if no logo exists
            $('#logoModal').modal('show');
        @endif
    });
</script>

<script>
$(document).ready(function() {
    $('#complaintTable').DataTable({
        responsive: true,
        autoWidth: false,
        paging: true,
        pageLength: 10,
        ordering: false, // ✅ Disables sorting globally
        columnDefs: [
            { orderable: false, targets: [0] }, // ✅ Disable sorting for Serial Number (1st column)
            { orderable: false, targets: '_all' } // ✅ Ensure all columns are non-sortable
        ]
    });
});


</script>


<!-- Include SweetAlert if not already included -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-logo-btn").forEach(button => {
        button.addEventListener("click", function() {
            let logoId = this.getAttribute("data-id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#BE6CFD",
                cancelButtonColor: "#B2BEB5",
                confirmButtonText: "Yes, delete it!",
                customClass: {
                    popup: "small-alert" // Custom class for width control
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-logo-form-${logoId}`).submit();
                }
            });
        });
    });
});
</script>

<style>
.small-alert {
    width: 400px !important; /* Adjust width as needed */
    height:300px !important; /* Adjust width as needed */
    font-size: 12px;
}
</style>



<script>
document.addEventListener("DOMContentLoaded", function () {
    let uploadButton = document.getElementById("uploadLogoBtn");
    let errorMessage = document.getElementById("errorMessage");

    uploadButton.addEventListener("click", function (event) {
        // Condition: Check if a logo already exists (adjust this condition as needed)
        let existingLogos = document.querySelectorAll(".logo-img").length;

        if (existingLogos > 0) {
            event.preventDefault(); // Prevent modal from opening if a logo exists
            errorMessage.style.display = "block"; // Show the error message

            setTimeout(function () {
                errorMessage.style.transition = "opacity 0.5s ease-out";
                errorMessage.style.opacity = "0";

                setTimeout(function () {
                    errorMessage.style.display = "none";
                    errorMessage.style.opacity = "1"; // Reset opacity for next time
                }, 500);
            }, 3000);
        }
    });
});



</script>

@endsection
