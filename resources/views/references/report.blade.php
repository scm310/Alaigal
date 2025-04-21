<!-- Author:Divya
Description:reference given report
Date:20/03/2025-->


@extends('memberlayout.navbar')
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
    margin-top:60px;
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
#referenceGivenTable thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#referenceGivenTable thead .sorting,
#referenceGivenTable thead .sorting_asc,
#referenceGivenTable thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#referenceGivenTable thead .sorting:after,
#referenceGivenTable thead .sorting:before,
#referenceGivenTable thead .sorting_asc:after,
#referenceGivenTable thead .sorting_asc:before,
#referenceGivenTable thead .sorting_desc:after,
#referenceGivenTable thead .sorting_desc:before {
    display: none !important;
}




        @media (max-width: 500px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: block; /* Ensure it's visible */
        text-align: center; /* Center align for better mobile view */
        margin-bottom: 10px; /* Add some spacing */
    }
}

table#referenceGivenTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
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

    @media (max-width: 768px) {
    .question-column {
        max-width: 100%;
        height: auto !important;
        overflow: visible !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }
    
    /* Ensure table cells wrap text properly */
    .table td {
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }
}

}

  /* Ensure form fields stack properly on smaller screens */
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

<div class="container-wrapper mt-3">
    <!-- Header -->
    <div class="header">Reference Given </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="referenceGivenTable" style="width: 100%;">
            <thead class="bg-light">
                <tr>
                <th class="text-center">S.No</th>
                <th class="text-center">Date & Time</th>
                <th class="text-center">Given To</th>
                <th class="text-center">Title</th>
                <th class="text-center">Reference Details</th>
                <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
            @isset($references)
            @foreach($references as $index => $reference)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d-m-Y h:i A', strtotime($reference->created_at)) }}</td>
                    <td>{{ optional($reference->givenTo)->first_name }} {{ optional($reference->givenTo)->last_name }}</td>

                    <td title="{{ $reference->title }}" data-toggle="tooltip" data-placement="top">
                        {{ Str::limit($reference->title, 30) }}
                    </td>
                    <td onclick="toggleExpand(this)">
    <div class="question-column">
        {{ $reference->details ?? 'No details available' }}
    </div>
</td>

                    <td>₹
    @php
        $num = (int) $reference->amount;
        $num = (string) $num;
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





                </tr>
                @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables Script -->
<script>
    $(document).ready(function() {
        $('#referenceGivenTable').DataTable({
            "responsive": true,
            "autoWidth": false
        });
    });
</script>

<script>
function toggleExpand(clickedElement) {
    // Collapse all expanded elements first
    document.querySelectorAll('.question-column.expanded').forEach(el => {
        if (el !== clickedElement.querySelector('.question-column')) {
            el.classList.remove('expanded');
        }
    });

    // Toggle expansion for the clicked element
    clickedElement.querySelector('.question-column').classList.toggle('expanded');
}
</script>




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
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#referenceGivenTable')) {
            $('#referenceGivenTable').DataTable({
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
        }
    });
</script>


@endsection











