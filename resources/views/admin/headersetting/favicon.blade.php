@extends('admin.layout.sidenavbar')

@section('content')

<style>
    .form-control {
        border: 1px solid rgb(162, 162, 162);
        border-radius: 5px;
        padding: 7px;
    }

    .form-control:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        margin-top: 33px;
        width:150px;
        margin-left:-125px; /* Full width on mobile */
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

    /* Ensure images inside table don't overflow */
    table img {
        max-width: 100%;
        height: auto;
    }

    /* Ensure table is scrollable on mobile */
    .table-responsive {
        overflow-x: auto;
    }


/* Responsive Styles */
@media (max-width: 768px) {
    .container {
        padding: 10px;
        margin-top: 35px;
    }

    .card {
        padding: 15px;
    }

    .header {
        font-size: 20px;
        padding: 10px;
    }

    .row.g-3 {
        flex-direction: column;
    }

    .col-md-4 {
        width: 100%;
        margin-bottom: 15px;
    }

    .btn-primary {
        width: 100%;
        margin-top: 15px;
    }

}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}
</style>

<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-center header">Favicon Settings</h2>

        @if(session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.headersetting.storeFavicon') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <label for="title" class="form-label fw-bold">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter favicon title" required>
                </div>

                <div class="col-12 col-md-4">
                    <label for="logo" class="form-label fw-bold">Upload Logo:</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                </div>

                <div class="col-12 col-md-4 text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-4 mt-4">
        <h3 class="mb-4 text-center header">Uploaded Favicon List</h3>

        @if($fav->isEmpty())
            <p class="text-center text-muted">No favicons uploaded yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" width="100%" id="complaintTable">
                    <thead >
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #e7cfcf;">
                        @foreach($fav as $index => $favicon)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $favicon->title }}</td>
                                <td>
                                    <img src="{{ asset('storage/app/public/favicon/' . $favicon->logo) }}" alt="Favicon" width="50">
                                </td>
                                <td>
                                    <form id="delete-form-{{ $favicon->id }}" action="{{ route('admin.headersetting.deleteFavicon', $favicon->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $favicon->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .small-swal {
        width: 320px !important;  /* Reduce popup width */
        font-size: 14px !important;  /* Smaller font size */
    }
    .swal2-title {
        font-size: 18px !important;  /* Smaller title font */
    }
    .swal2-content {
        font-size: 14px !important;  /* Smaller content font */
    }
    .swal2-popup .swal2-actions .swal2-confirm,
    .swal2-popup .swal2-actions .swal2-cancel {
        font-size: 13px !important;  /* Smaller button font size */
        padding: 6px 12px !important;  /* Smaller button padding */
    }
</style>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#BE6CFD",
            cancelButtonColor: "#B2BEB5",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                popup: 'small-swal'  // Apply the smaller size
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>


<script>
    $(document).ready(function() {
        $('#complaintTable').DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,
            pageLength: 10,
            ordering: false,
            columnDefs: [
                { orderable: false, targets: [0] },
                { orderable: false, targets: '_all' }
            ]
        });
    });
</script>

@endsection

