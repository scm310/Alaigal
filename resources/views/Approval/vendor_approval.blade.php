@extends('admin_layouts.app')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
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
</style>

@section('content')

<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="container ">
                    <!-- Card for the Vendor Approvals Table -->

                    <div class="card-header">
                        <h2 class="mb-0">Vendor Approvals</h2>
                    </div>
                    <div class="table-responsive">
                        <table id="productTable" style="width:100%" class="table table-striped table-bordered ">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Vendor</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Company Name</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Email</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Phone</th>
                                    <!-- <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Status</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>  -->
                                    <!-- New column for action buttons -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors as $vendor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> <!-- Display S.No. -->
                                    <td>{{ ucwords($vendor->name) }}</td>


                                    <td>{{ ucwords($vendor->company_name) }}</td>
                                    <td>{{ $vendor->email }}</td>
                                    <td>{{ $vendor->phone }}</td>
                                    <!-- <td>
                                        @if($vendor->status == 'deactivated')
                                        Rejected
                                        @else
                                        {{ ucwords($vendor->status) }}
                                        @endif
                                    </td> -->
                                    <!-- <td>
                                        <form action="{{ route('approval.vendor.updateStatus', $vendor->id) }}" method="POST">
                                            @csrf

                                            @if($vendor->status == 'approved')
                                            <button type="submit" name="status" value="deactivated" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Reject ">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            @elseif($vendor->status == 'deactivated')
                                            <button type="submit" name="status" value="approved" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Approve ">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            @elseif($vendor->status == 'pending')
                                            <button type="submit" name="status" value="approved" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Approve ">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="submit" name="status" value="deactivated" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Reject ">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            @endif
                                        </form>
                                    </td> -->
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
</script>
@endsection