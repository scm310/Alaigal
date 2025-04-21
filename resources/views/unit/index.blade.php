@extends('admin_layouts.app')

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add Font Awesome CDN for Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



<style>
    .modal-backdrop {
        background: rgba(0, 0, 0, 0.5) !important;
        /* Gray transparent background */
    }

    /* Apply border to the table */
    #vendorTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    /* Apply border to table header */
    #vendorTable th {
        border: 1px solid #ddd;
        padding: 8px;
        background-color: #f8f9fa;
        text-align: center;
    }

    /* Apply border to table cells */
    #vendorTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Apply border to dropdown button */
    .dropdown-menu {
        border: 1px solid #ddd;

        right: auto !important;
        left: 117px !important;
    }

    /* Optional: Adjust positioning */
    .dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;

    }

    /* Hide sorting icons in table headers */
    table#productTable thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */
    table#productTable thead .sorting:after,
    table#productTable thead .sorting:before,
    table#productTable thead .sorting_asc:after,
    table#productTable thead .sorting_asc:before,
    table#productTable thead .sorting_desc:after,
    table#productTable thead .sorting_desc:before {
        display: none !important;
        /* Hide the sorting arrows */
    }

    .modal-backdrop {
        background-color: white !important;
        width: 120% !important;
        /* Adjust width as needed */
        height: 120% !important;
        /* Adjust width as needed */
        left: -10%;
        /* Centering adjustment if needed */
    }

    #productTable th:nth-child(1),
    #productTable td:nth-child(1),
    #productTable th:nth-child(4),
    #productTable td:nth-child(4),
    #productTable th:nth-child(3),
    #productTable td:nth-child(3),
    #productTable th:nth-child(2),
    #productTable td:nth-child(2){
        width: 80px;
        /* Adjust the width as needed */
        min-width: 80px;
        /* Prevents shrinking */
        max-width: 80px;
        /* Prevents expanding */
        word-wrap: break-word;
        overflow: hidden;
        white-space: nowrap;

    }


    .btn-default {
        background-color: #853ede !important;
        color: white !important;
        border-color: #853ede !important;
    }

    /* Styling for btn-secondary */
    .btn-secondary {
        background-color: #853ede !important;
        /* Default Bootstrap gray */
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



<div class="container mt-4">
    <div class="card">
        <div class="card-header  text-white">
            <h4 class="mb-0">Unit of Measurement (UOM)</h4>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center mx-auto" role="alert" style="font-size: 14px; padding: 8px 16px; max-width: 400px;">
            {{ session('success') }}
            <span aria-hidden="true" class="close" data-dismiss="alert" data-toggle="tooltip" title="Close Alert" style="cursor: pointer;">&times;</span>
        </div>
        @endif






        <div class="card-body">
            <button class="btn btn-default mb-3" id="createBtn" data-toggle="modal" data-target="#createUOMModal">
                Create UOM
            </button>

            <div class="table-responsive">
                <table id="productTable" style="width:100%" class="table table-striped table-bordered ">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Unit</th>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Abbreviation</th>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->unit }}</td>
                            <td>{{ $unit->abbreviation }}</td>
                            <td class="text-center">
    <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $unit->id }}">
        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
    </button>
    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="delete-form" data-id="{{ $unit->id }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm delete-btn">
            <i class="fas fa-trash-alt"></i>
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

    <!-- Modal for Create UOM -->
    <div class="modal fade" id="createUOMModal" tabindex="-1" aria-labelledby="createUOMModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createUOMForm" method="POST" action="{{ route('units.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUOMModalLabel">Create UOM</h5>
                       
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create_unit">Unit Name</label>
                            <input type="text" id="create_unit" name="unit" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="create_abbreviation">Abbreviation</label>
                            <input type="text" id="create_abbreviation" name="abbreviation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Edit UOM -->
    <div class="modal fade" id="editUOMModal" tabindex="-1" aria-labelledby="editUOMModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUOMForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_unit_id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUOMModalLabel">Edit UOM</h5>
                        

                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_unit">Unit Name</label>
                            <input type="text" id="edit_unit" name="unit" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_abbreviation">Abbreviation</label>
                            <input type="text" id="edit_abbreviation" name="abbreviation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Handle "Create UOM" button click
            $('#createBtn').click(function() {
                $('#createUOMForm').trigger("reset");
                $('#createUOMModal').modal('show');
            });

            // Handle "Edit" button click
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/units/' + id + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function(unit) {
                        if (unit) {
                            $('#edit_unit_id').val(unit.id);
                            $('#edit_unit').val(unit.unit);
                            $('#edit_abbreviation').val(unit.abbreviation);
                            $('#editUOMForm').attr('action', '/units/' + unit.id);
                            $('#editUOMModal').modal('show');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetching data:", xhr);
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            $('#productTable').DataTable({
                "responsive": true, // Makes the table responsive for mobile screens
                "pageLength": 10, // Set the default number of rows per page
                "lengthMenu": [10, 25, 50, 100], // Options for rows per page
                "ordering": true, // Enable column ordering
                "searching": true, // Enable search functionality
                "info": true, // Display information about the table (e.g., showing entries 1 to 10 of 50)
            });
        });



        $(document).ready(function() {
            var table = $('#example').DataTable();

            $('.dataTables_filter').addClass('mb-3'); // Adds margin below search bar
        });

        $('#createUOMModal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".close, .btn-secondary").click(function() {
                $("#editUOMModal").modal("hide");
            });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let form = this.closest("form"); // Get the closest form
                
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