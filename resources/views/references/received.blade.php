<!-- Author:Divya
Description:Reference received report
Date:20/03/2025-->
@extends('memberlayout.navbar')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- Tooltip CSS -->
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

/* Table Styling */
.table {
    background-color: white !important;
    width: 100%;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd !important;
    white-space: nowrap;
}

.table thead {
    background-color: #ffffff !important;
    color: rgb(0, 0, 0) !important;
}

/* Tooltip Styling */
.tooltip-custom {
    position: relative;
    display: inline-block;
}

.tooltip-custom .tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Position above text */
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
    white-space: nowrap;
}

.tooltip-custom:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}


table#referencesReceivedTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}

/* Remove sorting icons from table headers */
#referencesReceivedTable thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#referencesReceivedTable thead .sorting,
#referencesReceivedTable thead .sorting_asc,
#referencesReceivedTable thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#referencesReceivedTable thead .sorting:after,
#referencesReceivedTable thead .sorting:before,
#referencesReceivedTable thead .sorting_asc:after,
#referencesReceivedTable thead .sorting_asc:before,
#referencesReceivedTable thead .sorting_desc:after,
#referencesReceivedTable thead .sorting_desc:before {
    display: none !important;
}

@media (max-width: 768px) {
    /* Ensure table cells wrap properly */
    #referencesReceivedTable tbody td {
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        text-align: left !important;
    }

    /* Specifically target the details column */
    .details {
        max-width: 100px; /* Restrict width */
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        white-space: normal !important;
        font-size: 12px; /* Adjust font size */
    }

    /* Fix DataTables responsiveness */
    .dataTables_wrapper {
        overflow-x: auto !important;
    }
}


/* Main Container for Question */
.question-column {
    display: -webkit-box;           /* Use flexbox-like behavior for text */
    -webkit-line-clamp: 2;          /* Limit the text to 2 lines */
    -webkit-box-orient: vertical;   /* Ensure vertical arrangement */
    overflow: hidden;               /* Hide any text beyond the 2 lines */
    text-overflow: ellipsis;        /* Add ellipsis (...) if the text overflows */
    white-space: normal;            /* Ensure the text wraps */
    word-wrap: break-word;          /* Ensure words break if they are too long */
}

/* Expandable Class */
.question-column.expanded {
    display: block;                 /* Change back to normal block display when expanded */
    white-space: normal;            /* Allow full content to wrap */
    word-wrap: break-word;          /* Allow long words to break and wrap */
    overflow: visible;              /* Ensure content is visible when expanded */
    text-overflow: unset;           /* Remove ellipsis when expanded */
}

/* Optional: Style the expandable row for visual feedback */
.expandable-row {
    cursor: pointer; /* Indicates that the row is clickable */
}

@media (max-width: 768px) {
    /* Ensure text wraps properly */
    .question-column {
        display: block !important; 
        -webkit-line-clamp: unset; 
        white-space: normal !important;
        overflow: visible !important;
    }

    /* Adjust expandable row behavior */
    .expandable-row {
        display: block;
        cursor: pointer;
        word-wrap: break-word !important;
    }

    /* Ensure table responsiveness */
    .dataTables_wrapper {
        overflow-x: auto !important;
    }
}

@media (max-width: 576px) {
    .container-wrapper {
        padding: 15px;
        margin-top: 20px !important; /* Adjust this value to push the form down */
    }
}






</style>
 
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="referenceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="given-tab" data-bs-toggle="tab" data-bs-target="#given" type="button"
                        role="tab" aria-controls="given" aria-selected="true">
                        Reference Given
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="received-tab" data-bs-toggle="tab" data-bs-target="#received" type="button"
                        role="tab" aria-controls="received" aria-selected="false">
                        Reference Received
                    </button>
                </li>
            </ul>



<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">References Received </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="referencesReceivedTable" style="width: 100%;">
        <thead class="bg-light">
    <tr>
        <th class="text-center">S.No</th>
        <th class="text-center">Date & Time</th>
        <th class="text-center">Referred By</th>
        <th class="text-center">Reference Title</th>
        <th class="text-center">Reference Amount</th>
        <th class="text-center">Reference Details</th>
    </tr>
</thead>

            <tbody style="background-color: #e7cfcf;">
            @isset($receivedReferences)
            @foreach($receivedReferences as $index => $reference)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d-m-Y h:i A', strtotime($reference->created_at)) }}</td>
                    <td>{{ optional($reference->givenBy)->first_name }} {{ optional($reference->givenBy)->last_name }}</td>
                    <td>
                        <span class="tooltip-custom">
                            {{ Str::limit($reference->title, 15) }}
                            <span class="tooltip-text">{{ $reference->title }}</span>
                        </span>
                    </td>
                    <td>₹
    @php
        $num = (int) $reference->amount; // Convert to integer to remove decimals

        $len = strlen($num);
        if ($len > 3) {
            $lastThree = substr($num, -3);
            $rest = substr($num, 0, -3);
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
            echo $rest . ',' . $lastThree;
        } else {
            echo $num;
        }
    @endphp
</td>


                    <!-- Add Reference Details -->
<td class="expandable-row" onclick="this.querySelector('.question-column').classList.toggle('expanded')">
    <div class="question-column">
        {{ $reference->details ?? 'No details available' }}
    </div>
</td>


                </tr>
                @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".expandable-row").forEach(function (row) {
        row.addEventListener("click", toggleExpand);
    });

    function toggleExpand(event) {
        event.preventDefault(); // Prevent any unintended behavior

        // Collapse any other rows that are currently expanded
        let expandedRows = document.querySelectorAll(".expandable-row .question-column.expanded");
        expandedRows.forEach(function (expandedRow) {
            // Remove the 'expanded' class from any other expanded rows
            expandedRow.classList.remove("expanded");
        });

        // Now expand the clicked row
        let details = this.querySelector(".question-column");
        details.classList.toggle("expanded");
    }
});
</script>

<!-- DataTables Initialization -->
<script>
$(document).ready(function () {
    $('#referencesReceivedTable').DataTable({
        responsive: true,
        paging: true,
        sorting:false,
        pageLength: 10,
        language: {
            lengthMenu: "Show _MENU_ entries",
            emptyTable: "No references received yet."
        }
    });
});


</script>

@endsection
