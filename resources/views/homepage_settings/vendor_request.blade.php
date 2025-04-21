@extends('admin_layouts.app')

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

    .swal2-cancel:hover {
        background-color: gray !important;
        color: white !important;
    }

    
</style>
@section('content')
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="container ">
                    <h3>Total Number of Vendor Requests: {{ count($vendorRequests) }}</h3>

                    <div class="table-responsive">
                        <table id="productTable" style="width:100%" class="table table-striped table-bordered ">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Vendor</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Email</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Message</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Date & Time</th>
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Status</th> <!-- Status Column -->
                                    <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th> <!-- Action Column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendorRequests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request->name }}</td>
                                    <td>{{ $request->email }}</td>
                                    <td>
                                        <div class="expand"
                                            title="{{ strlen($request->message) > 30 ? 'Click to view the message' : '' }}"
                                            onclick="toggleExpand(this)"
                                            data-full-message="{{ $request->message }}"
                                            style="cursor: pointer; max-width: 200px; word-wrap: break-word; white-space: normal; overflow-wrap: break-word;">
                                            {{ strlen($request->message) > 30 ? substr($request->message, 0, 30) . '...' : $request->message }}
                                        </div>
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A') }}</td>


                                    <!-- Status Column -->
                                    <td>
                                        @if($request->status == 'closed')
                                        <span class="badge bg-primary">Closed</span>
                                        @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Action Column (Without View Button) -->
                                    <td>
    @if($request->status == 'pending')
        <!-- Close Button -->
        <a href="{{ route('customer_support.close', $request->id) }}" class="btn btn-primary btn-sm">Close</a>
    @else
        <!-- Delete Button with SweetAlert -->
        <form id="delete-form-{{ $request->id }}" action="{{ route('customer_support.delete', $request->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $request->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif
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



    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('.dataTables_filter').addClass('mb-3'); // Adds margin below search bar
    });


    
</script>
<script>
    function toggleExpand(element) {
        let fullMessage = element.getAttribute("data-full-message");

        if (element.innerText.length > 30) {
            if (element.classList.contains("expanded")) {
                // Collapse the message
                element.innerText = fullMessage.substring(0, 30) + "...";
                element.classList.remove("expanded");
            } else {
                // Expand the message
                element.innerText = fullMessage;
                element.classList.add("expanded");
            }
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let requestId = this.getAttribute("data-id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#853ede",
                    cancelButtonColor: "#853ede",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${requestId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection