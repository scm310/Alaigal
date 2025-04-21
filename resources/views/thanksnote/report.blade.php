<!-- Author:Divya
Description:Thanksnote given report
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
    font-size: 12px; /* Set font size to 12px */
}

.table thead {
    background-color: #ffffff !important;
    color: rgb(0, 0, 0) !important;
}

table#thanksnoteGivenTable thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}


/* Remove sorting icons from table headers */
#thanksnoteGivenTable thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#thanksnoteGivenTable thead .sorting,
#thanksnoteGivenTable thead .sorting_asc,
#thanksnoteGivenTable thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#thanksnoteGivenTable thead .sorting:after,
#thanksnoteGivenTable thead .sorting:before,
#thanksnoteGivenTable thead .sorting_asc:after,
#thanksnoteGivenTable thead .sorting_asc:before,
#thanksnoteGivenTable thead .sorting_desc:after,
#thanksnoteGivenTable thead .sorting_desc:before {
    display: none !important;
}


/* Ensure proper responsiveness */
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
    #thanksnoteGivenTable th:nth-child(6), 
    #thanksnoteGivenTable td:nth-child(6) {
        width: 120px;  /* Set the desired width */
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

@media (max-width: 576px) {
    .container-wrapper {
        padding: 15px;
        margin-top: 20px !important; /* Adjust this value to push the form down */
    }
}

</style>

<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Thanksnote Given </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="thanksnoteGivenTable" style="width:100%;">
            <thead class="bg-light">
                <tr>
                <th class="text-center">S.No</th>
                <th class="text-center">Date & Time</th>
                <th class="text-center">Thanks Note Given To</th>
                <th class="text-center">Reference Title</th>
                <th class="text-center">Quoted Reference Amount</th>
                <th class="text-center">Thanks Note Title</th>
                <th class="text-center">Thanks Note Amount</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
                            @foreach($thanksnotes as $index => $thanksnote)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('d-m-Y h:i A', strtotime($thanksnote->created_at)) }}</td>

                                    <td>{{ optional($thanksnote->thanksnoteTo)->first_name }} {{ optional($thanksnote->thanksnoteTo)->last_name }}</td>
                                    
                                    <td onclick="this.querySelector('.question-column').classList.toggle('expanded')">
                                        <div class="question-column">
                                            {{ optional($thanksnote->reference)->title ?? 'No details available' }}
                                        </div>
                                    </td>
                                    
                                    
                                    <td>₹ 
    @php
        $amount1 = optional($thanksnote->reference)->amount ?? 0;
        $whole1 = (int) $amount1;

        $len1 = strlen($whole1);
        if ($len1 > 3) {
            $lastThree1 = substr($whole1, -3);
            $rest1 = substr($whole1, 0, -3);
            $rest1 = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest1);
            echo $rest1 . ',' . $lastThree1;
        } else {
            echo $whole1;
        }
    @endphp
</td>

<td onclick="toggleExpand(this)">
    <div class="question-column">
        {{ $thanksnote->thanksnote_title ?? 'No details available' }}
    </div>
</td>


<td>₹ 
    @php
        $amount2 = $thanksnote->thanksnote_amount;
        $whole2 = (int) $amount2;

        $len2 = strlen($whole2);
        if ($len2 > 3) {
            $lastThree2 = substr($whole2, -3);
            $rest2 = substr($whole2, 0, -3);
            $rest2 = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest2);
            echo $rest2 . ',' . $lastThree2;
        } else {
            echo $whole2;
        }
    @endphp
</td>

                                </tr>
                            @endforeach
                        </tbody>
        </table>
    </div>
</div>

<!-- DataTables Initialization -->
<script>
$(document).ready(function () {
    $('#thanksnoteGivenTable').DataTable({
        responsive: true,
        paging: true,
        pageLength: 10,
        language: {
            lengthMenu: "Show _MENU_ entries",
            emptyTable: "No Thanksnotes given yet."
        }
    });

    // Enable Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<script>
function toggleExpand(clickedElement) {
    // Find all expanded elements and collapse them
    document.querySelectorAll('.question-column.expanded').forEach(el => {
        if (el !== clickedElement.querySelector('.question-column')) {
            el.classList.remove('expanded');
        }
    });

    // Toggle the clicked element
    clickedElement.querySelector('.question-column').classList.toggle('expanded');
}
</script>

@endsection
