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
/* Specifically target the DataTables sorting classes */
table#complaintTable thead .sorting:after,
table#complaintTable thead .sorting:before,
table#complaintTable thead .sorting_asc:after,
table#complaintTable thead .sorting_asc:before,
table#complaintTable thead .sorting_desc:after,
table#complaintTable thead .sorting_desc:before {
    display: none !important; /* Hide the sorting arrows */
}

.bg-primary {
    background-color:white !important;
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
    <div class="header">Subscription Expired Members </div>
        <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
        <thead>
    <tr>
        <th>S.No</th> <!-- Added Serial Number Column -->
        <th>User Name</th>
        <th>Company Details</th> <!-- Includes Company, Designation & Location -->
        <th>Start Date</th>
        <th>End Date</th>
        <th>Notification</th>
    </tr>
</thead>

    <tbody style="background-color: #e7cfcf;">
    @foreach($expiringSubscriptions as $index => $subscription)
    <tr>
        <td>{{ $index + 1 }}</td> <!-- S.No -->
        <td>{{ $subscription->user_name }}</td>
        <td><strong>{{ $subscription->company_name }}</strong><br>
            <small class="text-muted">{{ $subscription->designation }}</small><br>
            <small class="text-muted">{{ $subscription->location }}</small>
        </td>
        <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d-m-Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d-m-Y') }}</td>
        <td>
            <form action="{{ route('admin.sendRenewalNotification', $subscription->user_id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="background-color: #866ec7; border-color: #866ec7;">
    Send Notification
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
        ordering: false,
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

@if(session('success') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '{{ session("success") ? "success" : "error" }}',
            title: '{{ session("success") ? "Success!" : "Error!" }}',
            text: "{{ session('success') ?? session('error') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endsection




