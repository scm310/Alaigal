@extends('admin.layout.sidenavbar')


@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<style>

    .container{
        overflow-x: hidden;
    }


@media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: none; /* Hide Show Entries & Search on mobile */
    }
}

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


.bg-primary {
    background-color:white !important;
}


@media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: block; /* Ensure it's visible */
        text-align: center; /* Center align for better mobile view */
        margin-bottom: 10px; /* Add some spacing */
    }
}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}


</style>
<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Subscribed Members </div>
        <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%; font-size: 12px;">
    <thead>
        <tr>
            <th>S.No</th> <!-- Serial Number Column -->
            <th>Member Name</th>
            <th>Company Details</th>
            <th>Payment Details</th>
            <th>Plan Type</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>
    <tbody style="background-color: #e7cfcf;">
        @foreach($subscriptions as $index => $subscription)
        <tr>
            <td>{{ $index + 1 }}</td> <!-- Serial Number Column -->
            <td>{{ $subscription->user_name }}</td>
            
            <!-- Company Details Column -->
            <td>
                <strong>{{ $subscription->company_name }}</strong><br>
                <small class="text-muted">Designation: {{ $subscription->designation }}</small><br>
                <small class="text-muted">Location: {{ $subscription->location }}</small>
            </td>

            <!-- Payment Details Column -->
            <td>
                <strong>Duration: {{ $subscription->duration }} Months</strong><br>
                <small class="text-muted">Amount: ₹{{ $subscription->total_amount }}</small><br>
              
            </td>

            <!-- Plan Type Column (Merged as MP, MMP) -->
            <td><strong>{{ $subscription->plan_types }}</strong></td>

            <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d-m-Y') }}</td>
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
            },
            {
                orderable: false,
                targets: '_all' // Disable sorting for all columns
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
