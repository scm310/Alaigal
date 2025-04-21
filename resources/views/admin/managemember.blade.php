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
        font-size: 0.55rem;  /* Reduce font size */
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


.bg-primary {
    background-color:white !important;
}


#complaintTable {
        font-size: 12px; /* Adjust font size */
    }

    /* Adjust column widths */
    #complaintTable th, 
    #complaintTable td {
        white-space: nowrap; /* Prevent text wrapping */
    }

    /* Set specific widths for each column */
    #complaintTable th:nth-child(1), #complaintTable td:nth-child(1) { width: 120px; } /* Name */
    #complaintTable th:nth-child(2), #complaintTable td:nth-child(2) { width: 150px; } /* Email */
    #complaintTable th:nth-child(3), #complaintTable td:nth-child(3) { width: 100px; } /* Phone */
    #complaintTable th:nth-child(4), #complaintTable td:nth-child(4) { width: 150px; } /* Company Name */
    #complaintTable th:nth-child(5), #complaintTable td:nth-child(5) { width: 120px; } /* Member Status */
    #complaintTable th:nth-child(6), #complaintTable td:nth-child(6) { width: 120px; } /* Status */
    #complaintTable th:nth-child(7), #complaintTable td:nth-child(7) { width: 100px; } /* Location */
    #complaintTable th:nth-child(8), #complaintTable td:nth-child(8) { width: 100px; } /* Designation */
    #complaintTable th:nth-child(9), #complaintTable td:nth-child(9) { width: 120px; } /* Registered Date */
    #complaintTable th:nth-child(10), #complaintTable td:nth-child(10) { width: 80px; } /* Action */

    /* Reduce button size */
    .btn-sm {
        font-size: 11px;
    }


/* If the + icon is inside a button or span */
.plus-icon {
    margin-right: 8px; /* Adjust spacing */
}

.container-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
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

    /* Search Bar */
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }
    #rejectionReason {
    border: 1px solid #696767; /* Black border */
    border-radius: 5px; /* Optional: rounded corners */
    padding: 8px; /* Add some spacing inside */
    width: 100%; /* Full width */
    min-height: 100px; /* Set minimum height */
    font-size: 14px; /* Adjust text size */
    outline: none; /* Remove blue outline on focus */
}

/* Add focus effect */
#rejectionReason:focus {
    border-color: #007bff; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: glowing effect */
}

.tooltip-inner {
    font-size: 12px; /* Reduce font size */
    background-color: white !important; /* Solid background color */
    color: #000 !important; /* Change text color to black */
    border-radius: 5px; /* Round the corners */
    padding: 8px; /* Add some padding */
    opacity: 1 !important; /* Ensure full opacity */
    filter: none !important; /* Remove any transparency effect */
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2); /* Add subtle shadow for better visibility */
}


/* Ensure tooltip arrow matches background */
.tooltip.bs-tooltip-top .tooltip-arrow::before,
.tooltip.bs-tooltip-bottom .tooltip-arrow::before,
.tooltip.bs-tooltip-start .tooltip-arrow::before,
.tooltip.bs-tooltip-end .tooltip-arrow::before {
    background-color: white !important; 
    border-color: white !important;
}

table#complaintTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}

.tooltip-inner {
    white-space: pre-line; /* Enables line breaks */
    text-align: left; /* Align text properly */
    max-width: 250px; /* Adjust width for readability */
    line-height: 1.2; /* Reduce spacing between lines */
    padding: 5px 8px; /* Adjust padding if needed */
}



</style>




<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Manage Member</div>
        <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width:85%;">
    <thead class="bg-light text-black">
        <tr>
            <th>S.No</th> <!-- Serial Number Column -->
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company Details</th> <!-- Merged column -->
            <th>Status</th>
            <th>Registered Date</th>
            <th>Actions</th> <!-- Moved all buttons into this column -->
        </tr>
    </thead>
    <tbody style="background-color: #e7cfcf;">
        @foreach($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td> <!-- Serial Number -->
            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_number }}</td>
            <td class="hover-info" data-bs-toggle="tooltip" data-bs-html="true" 
    title="Company Name: {{ $user->company_name }}&#10;
           Designation: {{ $user->designation }}&#10;
           Location: {{ $user->location }}">
    
    <strong>{{ $user->company_name }}</strong><br>
    <small class="text-muted">{{ $user->designation }}</small><br>
    <small class="text-muted">{{ $user->location }}</small>
</td>

<td style="text-align: center; font-size: 1.2rem; font-weight: bold;">
    @if($user->approve_status == 0)
        <span class="badge bg-warning" data-bs-toggle="tooltip" title="Pending">P</span>
    @elseif($user->approve_status == 1)
        <span class="badge bg-success" data-bs-toggle="tooltip" title="Approved">A</span>
    @elseif($user->approve_status == 3)
        <span class="badge bg-danger" data-bs-toggle="tooltip" title="Rejected">R</span>
    @endif
</td>


            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
            <td>
            <form action="{{ route('users.approve', $user->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-success btn-sm" 
        @if($user->approve_status == 1) disabled @endif 
        data-bs-toggle="tooltip" title="Approve">
        <i class="fas fa-check"></i> <!-- Tick Icon -->
    </button>
</form>

<button class="btn btn-danger btn-sm" 
    onclick="openRejectModal('{{ $user->id }}', '{{ $user->first_name . ' ' . $user->last_name }}')" 
    @if($user->approve_status == 3) disabled @endif 
    data-bs-toggle="tooltip" title="Reject">
    <i class="fas fa-times"></i> <!-- X Icon -->
</button>
<form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-lg text-danger" onclick="confirmDelete({{ $user->id }})"
        style="font-size: 1.0rem; padding: 10px 15px;" data-bs-toggle="tooltip" title="Delete">
        <i class="fa fa-trash-alt fa-lg"></i> <!-- Larger Delete Icon -->
    </button>
</form>


            </td>
        </tr>
        @endforeach
    </tbody>
</table>





        </div>
    </div>


<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" action="{{ route('users.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="rejectUserId">
                    <p>Are you sure you want to reject <strong id="rejectUserName"></strong>?</p>
                    <label>Reason for Rejection:</label>
<textarea name="rejection_reason" id="rejectionReason" class="form-control" required></textarea>
<br>
                    <button type="submit" class="btn btn-danger" style="background-color: #BE6CFD; border-color:#BE6CFD;">Send Email & Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript to Open Modal -->
<script>
    function openRejectModal(userId, userName) {
        $('#rejectUserId').val(userId);
        $('#rejectUserName').text(userName);
        $('#rejectModal').modal('show');
    }
</script>




<script>
    // Initialize DataTable
    var table = new DataTable('#complaintTable', {
        "ordering": false,      // Disable column ordering
        "order": [],            // Clear default ordering
        "autoWidth": false,     // Disable automatic column resizing
        "drawCallback": function() {
            // Reinitialize Bootstrap tooltips after each draw (pagination, search, etc.)
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });

    // Function to open reject modal
    function openRejectModal(userId, userName) {
        document.getElementById('rejectUserId').value = userId;
        document.getElementById('rejectUserName').textContent = userName;
        $('#rejectModal').modal('show');
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor:  "#BE6CFD",
        cancelButtonColor:  "#B2BEB5",
        confirmButtonText: "Yes, delete it!",
        width: '300px', // Reduce the width
        padding: '10px', // Reduce padding
        customClass: {
            popup: 'small-alert' // Custom class for more styling if needed
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

    // Show success message after deletion
    @if(session('delete_success'))
       Swal.fire({
            title: 'Deleted!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#BE6CFD',
            customClass: {
                popup: 'small-alert',  // Custom class for the modal
            },
            width: '300px',  // You can set the width to a specific size
        });
    @endif
    
</script>
<style>
.small-alert {
    width: 400px !important;  /* Adjust width as needed */
    height: 300px !important; /* Adjust height as needed */
    font-size: 12px !important;
}
</style>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#BE6CFD',
        confirmButtonText: 'OK'
    });
</script>
@endif


@if(session('success') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '{{ session("success") ? "success" : "error" }}',
        title: '{{ session("success") ? "Success!" : "Rejected!" }}',
        text: "{{ session('success') ?? session('error') }}",
        confirmButtonColor: '#BE6CFD',
        confirmButtonText: 'OK'
    });
</script>
@endif
<style>
    .small-swal {
        font-size: 14px;  /* Adjust the font size */
    }
    .small-swal-popup {
    font-size: 14px !important; /* Reduce font size */
}

</style>

@endsection









