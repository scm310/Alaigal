<!-- Author:Divya
Description:Thanksnote received report
Date:20/03/2025-->

@extends('memberlayout.navbar')

@section('content')

<!-- DataTables CSS & JS -->
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

/* Table Styling */
.table {
    background-color: white !important;
    width: 100%;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd !important;
    white-space: nowrap;
    text-align: center;
    font-size: 12px; /* Set font size to 12px */
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
    bottom: 125%;
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

table#thanksnotesReceivedTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}


/* Remove sorting icons from table headers */
#thanksnotesReceivedTable thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#thanksnotesReceivedTable thead .sorting,
#thanksnotesReceivedTable thead .sorting_asc,
#thanksnotesReceivedTable thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#thanksnotesReceivedTable thead .sorting:after,
#thanksnotesReceivedTable thead .sorting:before,
#thanksnotesReceivedTable thead .sorting_asc:after,
#thanksnotesReceivedTable thead .sorting_asc:before,
#thanksnotesReceivedTable thead .sorting_desc:after,
#thanksnotesReceivedTable thead .sorting_desc:before {
    display: none !important;
}



/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
}

.question-column{
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
    .question-column.expanded{
        height: auto;
        white-space: normal;
        word-wrap: break-word;
    }
</style>
<style>
    #thanksnotesReceivedTable th:nth-child(5), 
    #thanksnotesReceivedTable td:nth-child(5) {
        width: 150px;  /* Set the desired width */
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 576px) {
    .container-wrapper {
        padding: 15px;
        margin-top: 20px !important; /* Adjust this value to push the form down */
    }
}
</style>


<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Thanksnote Received </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="thanksnotesReceivedTable" style="width: 100%;">
            <thead class="bg-light">
                <tr>
                <th class="text-center">S.No</th>
                <th class="text-center">Date & Time</th>
                <th class="text-center">Received From</th>
                <th class="text-center">Reference Title</th>
                <th class="text-center">Thanks Note Title</th>
                <th class="text-center">Thanks Note Amount</th>
                <th class="text-center">Quoted Reference Amount</th>
                </tr>
                <tbody style="background-color: #e7cfcf;">
    @if($receivedThanksnotes->isEmpty())
       
    @else
        @foreach($receivedThanksnotes as $index => $thanksnote)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d-m-Y h:i A', strtotime($thanksnote->created_at)) }}</td>
                <td>{{ optional($thanksnote->sourceMember)->first_name }} {{ optional($thanksnote->sourceMember)->last_name }}</td>

                
              <!-- Reference Title with Tooltip -->
<td onclick="this.querySelector('.question-column').classList.toggle('expanded')">
    <div class="question-column">
        {{ $thanksnote->reference->title ?? 'No details available' }}
    </div>
</td>

<td onclick="this.querySelector('.question-column').classList.toggle('expanded')">
    <div class="question-column">
        {{ $thanksnote->thanksnote_title ?? 'No details available' }}
    </div>
</td>

                
                <td>₹ 
    @php
        $num1 = (int) $thanksnote->thanksnote_amount; // Convert to integer to remove decimals

        $len1 = strlen($num1);
        if ($len1 > 3) {
            $lastThree1 = substr($num1, -3);
            $rest1 = substr($num1, 0, -3);
            $rest1 = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest1);
            echo $rest1 . ',' . $lastThree1;
        } else {
            echo $num1;
        }
    @endphp
</td>

<td>₹ 
    @php
        $num2 = (int) ($thanksnote->reference->amount ?? 0); // Convert to integer to remove decimals

        $len2 = strlen($num2);
        if ($len2 > 3) {
            $lastThree2 = substr($num2, -3);
            $rest2 = substr($num2, 0, -3);
            $rest2 = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest2);
            echo $rest2 . ',' . $lastThree2;
        } else {
            echo $num2;
        }
    @endphp
</td>


            </tr>
        @endforeach
    @endif
</tbody>

        </table>
    </div>
</div>

<!-- DataTables Initialization -->
<script>
$(document).ready(function () {
    $('#thanksnotesReceivedTable').DataTable({
        responsive: true,
        paging: true,
        pageLength: 10,
        language: {
            lengthMenu: "Show _MENU_ entries",
            emptyTable: "No Thanksnotes received yet."
        }
    });
});
</script>

@endsection
