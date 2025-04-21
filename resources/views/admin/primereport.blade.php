@extends('admin.layout.sidenavbar')

@section('content')



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<style>

/* Main Container */
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
    .card{
      padding:10px;
    }

        /* Reduce font size for table headers and content */
        #complaintTable th, #complaintTable td {
        font-size: 12px; /* Adjust size as needed */
        white-space: normal; /* Allow text wrapping */
        word-wrap: break-word; /* Ensure long words break */
    }

    /* Ensure headers wrap text instead of stretching */
    #complaintTable th {
        max-width: 120px; /* Adjust width as needed */
        overflow-wrap: break-word;
        text-align: center;
    }

    

    @media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: none; /* Hide Show Entries & Search on mobile */
    }

        .table td {
        max-width: 150px; /* Adjust as needed */
        white-space: normal !important; /* Allow text to wrap */
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word; /* Break long words */
    }
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

    /* Custom Tooltip Style */
    .tooltip-inner {
            background-color: black !important;
            color: white !important;
            border-radius: 5px;
            padding: 10px;
            font-weight: bold;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip Arrow */
        .bs-tooltip-top .tooltip-arrow::before {
            border-top-color: black !important;
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
    <div class="header">Prime Report</div>
        <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Member Name</th>
            <th>Products</th>
            <th>Services</th>
            <th>Testimonials</th>
            <th>Clients</th>
            <th>Projects</th>
            <th>Website</th>
            <th>Presence in Marketplace</th>
            <th>Type of User</th>
        </tr>
    </thead>
    <tbody style="background-color: #e7cfcf;">
        @foreach($members as $key => $member)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
            <td>{{ $member->product_count }}</td>
            <td>{{ $member->service_count }}</td>
            <td>{{ $member->testimonial_count }}</td>
            <td>{{ $member->client_count }}</td>
            <td>{{ $member->completed_project_count }}</td>
            <td>{{ $member->website ? 'Yes' : 'No' }}</td>
            <td>{{ $member->presence_in_marketplace }}</td> <!-- Displays Yes/No based on marketplace presence -->
            <td>{{ $member->user_type }}</td> <!-- Displays MP, MMP, MP&MMP, or Free Trial -->
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
    </div>


<!-- Custom Styling -->
<style>
    .table {
        background-color: white !important; /* Ensure table is white */
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd !important; /* Soft gray border */
    }
    .table thead {
        background-color: #ffffff !important; /* Dark header */
        color: rgb(0, 0, 0) !important;
    }
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

   

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<script>
            new DataTable('#complaintTable');
            $(document).ready(function () {
    $('#complaintTable').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: -1
            }
        },
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets: -1
            }
        ],
        paging: true,
        pageLength: 10,
        language: {
            lengthMenu: "Show MENU entries",
            emptyTable: "No rejected members found." // This message will be displayed when no data is available
        }
    });
});

        </script>

@endsection


