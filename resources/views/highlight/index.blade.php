@extends('admin_layouts.app')

<style>
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

     /* Ensure cancel button turns gray on hover */
     .swal2-cancel:hover {
        background-color: gray !important;
        color: white !important;
    }

    #productTable th:nth-child(1),
    #productTable td:nth-child(1),
    
    #productTable th:nth-child(3),
    #productTable td:nth-child(3)
    {
        width: 120px;
        /* Adjust the width as needed */
        min-width: 120px;
        /* Prevents shrinking */
        max-width: 120px;
        /* Prevents expanding */
        word-wrap: break-word;
        overflow: hidden;
        white-space: nowrap;

    }

    
    
    #productTable th:nth-child(3),
    #productTable td:nth-child(3)
    {
        width: 180px;
        /* Adjust the width as needed */
        min-width: 180px;
        /* Prevents shrinking */
        max-width: 180px;
        /* Prevents expanding */
        word-wrap: break-word;
        overflow: hidden;
        white-space: nowrap;

    }
</style>
@section('content')
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h2>Highlight List</h2>
            <a href="{{ route('highlight.create') }}" class="btn btn-default mb-3">Add New Highlight</a>

            @if(session('success'))
<div class="d-flex justify-content-center">
    <div class="alert alert-success alert-dismissible fade show p-2 text-center" role="alert" style="max-width: 400px; width: 100%;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif



            <!-- Show Error Message -->
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-body">
                <div class="row mb-3">
                    <div class="container ">


                        <div class="row">

                            <div class="table-responsive">
                            <table id="productTable" style="width:100%" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Title</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($highlights as $highlight)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td> <!-- Auto-incrementing S.No -->
        <td class="text-center">{{ $highlight->name }}</td>

        <td class="text-center">
            <a href="{{ route('highlight.edit', $highlight->id) }}" class="btn btn-warning"> <i class="fas fa-edit"></i></a>

            <!-- Delete Button -->
            <button class="btn btn-danger delete-btn" data-id="{{ $highlight->id }}">   <i class="fas fa-trash-alt"></i></button>

            <!-- Hidden Delete Form -->
            <form id="delete-form-{{ $highlight->id }}" action="{{ route('highlight.destroy', $highlight->id) }}" method="POST" style="display:none;">
                @csrf @method('DELETE')
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

</table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let highlightId = this.getAttribute("data-id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: " #853ede",
                    cancelButtonColor: " #853ede",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${highlightId}`).submit();
                    }
                });
            });
        });
    });
</script>


@endsection