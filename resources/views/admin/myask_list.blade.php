@extends('admin.layout.sidenavbar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<style>
.container{
    overflow-y: hidden;
}

@media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: none; /* Hide Show Entries & Search on mobile */
    }

        .table td {
        max-width: 155px; /* Adjust as needed */
        white-space: normal !important; /* Allow text to wrap */
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word; /* Break long words */
    }
}
#complaintTable th, #complaintTable td {
    padding: 5px; /* Reduce padding */
    font-size: 14px; /* Reduce font size */
    white-space: nowrap; /* Prevent text wrapping */
}

#complaintTable {
    table-layout: fixed; /* Fix the table layout */
}

#complaintTable td:nth-child(5) {
    text-align:center;
}




#complaintTable th, #complaintTable td {
    padding: 5px; /* Reduce padding */
    font-size: 14px; /* Reduce font size */
    white-space: nowrap; /* Prevent text wrapping */
}

#complaintTable {
    table-layout: fixed; /* Fix the table layout */
    width: 100%;
}

/* Define column widths for larger screens */
#complaintTable th:nth-child(1),
#complaintTable td:nth-child(1) {
    width: 10%;
}

#complaintTable th:nth-child(2),
#complaintTable td:nth-child(2) {
    width: 20%;
    word-wrap: break-word;
    white-space: normal;
}





/* General container styling */
.container {
    overflow-y: hidden;
}

/* Ensure DataTable is scrollable on mobile */
@media (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Hide 'Show Entries' and 'Search' fields for smaller screens */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    /* Adjust table cells for better readability */
    .table td, .table th {
        font-size: 0.85rem;
        padding: 8px;
        white-space: normal !important;
        word-wrap: break-word;
        text-align: center;
    }

    /* Ensure action buttons in the table are more compact */
    .table td a, .table td button {
        font-size: 0.85rem;
        padding: 5px;
        margin-right: 5px;
    }

    /* Optimize table column width */
    #complaintTable {
        table-layout: auto;
        width: 100%;
    }

    #complaintTable th:nth-child(1),
    #complaintTable td:nth-child(1) {
        width: 15%;
    }
    #complaintTable th:nth-child(2),
    #complaintTable td:nth-child(2), {
        width: 45%;

    }

    #complaintTable th:nth-child(4),
    #complaintTable td:nth-child(4) {
        width: 45%;

    }
}

/* Remove sorting icons from DataTable headers */
table#complaintTable thead .sorting:after,
table#complaintTable thead .sorting:before,
table#complaintTable thead .sorting_asc:after,
table#complaintTable thead .sorting_asc:before,
table#complaintTable thead .sorting_desc:after,
table#complaintTable thead .sorting_desc:before {
    display: none !important;
}

/* Alert box responsive settings */
.alert {
    width: 30%;
    position: relative;
    margin: 10px auto;
}

@media (max-width: 768px) {
    .alert {
        width: 80%;
    }
    .btn-close {
        font-size: 1.2rem;
        width: 1.2rem;
        height: 1.2rem;
    }
}

@media (max-width: 480px) {
    .alert {
        width: 100%;
    }
    .btn-close {
        font-size: 1rem;
        width: 1rem;
        height: 1rem;
    }
}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
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

    .container-wrapper{
        margin-top:19px!important;
    }
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

.bg-primary {
    background-color:white !important;
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

.question-column {
    max-width: 250px;
    height: 26px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    padding: 5px;
    text-align: left;
    cursor: pointer;
    transition: height 0.3s ease-in-out;
}

/* Expanded state - applies when clicked */
.question-column.expanded {
    height: auto;
    white-space: normal;
    word-wrap: break-word;
}

   /* Main Container */
   .container-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
        overflow: hidden;
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

    @media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: block; /* Ensure it's visible */
        text-align: center; /* Center align for better mobile view */
        margin-bottom: 10px; /* Add some spacing */
    }
}
</style>

<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">My Ask</div>


        <div class="card-body">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Ask</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="background-color: #e7cfcf;">
    @foreach($asks as $index => $ask)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $ask->created_at->format('d-m-Y h:i A') }}</td>
            <td>
                @if($ask->member)
                    {{ $ask->member->first_name }} {{ $ask->member->last_name }}
                @else
                    Unknown User
                @endif
            </td>
            <td>
                @if($ask->member)
                    {{ $ask->member->phone_number }}
                @else
                    N/A
                @endif
            </td>
            <td>
                <div class="question-column" onclick="toggleAsk(this)">
                    {{ $ask->my_ask }}
                </div>
            </td>
            <td>
                <form id="delete-form-{{ $ask->id }}" action="{{ route('ask.destroy', $ask->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete({{ $ask->id }})"
                        style="border: none; background: none; padding: 2px; display: flex; align-items: center; justify-content: center; width: 100%;">
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
</div>


<script>
    let previousExpanded = null; // Track the previously expanded row

    function toggleAsk(element) {
        // If there is a previously expanded row and it's not the current one, collapse it
        if (previousExpanded && previousExpanded !== element) {
            previousExpanded.classList.remove('expanded');
        }

        // Toggle the current row's expanded state
        element.classList.toggle('expanded');
        
        // Update the previousExpanded variable to the current element
        previousExpanded = element.classList.contains('expanded') ? element : null;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            popup: 'small-alert' // Custom class for more styling if needed
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
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
        language: {
            lengthMenu: "Show MENU entries"
        }
    });
});
</script>




@endsection









