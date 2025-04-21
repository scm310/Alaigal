@extends('admin.layout.sidenavbar')

@section('content')



<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        background: linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%);
        color: black;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .card {
        padding: 10px;
    }

    /* Reduce font size for table headers and content */
    #complaintTable th,
    #complaintTable td {
        font-size: 12px;
        /* Adjust size as needed */
        white-space: normal;
        /* Allow text wrapping */
        word-wrap: break-word;
        /* Ensure long words break */
    }

    /* Ensure headers wrap text instead of stretching */
    #complaintTable th {
        max-width: 120px;
        /* Adjust width as needed */
        overflow-wrap: break-word;
        text-align: center;
    }



    @media (max-width: 500px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: none;
            /* Hide Show Entries & Search on mobile */
        }

        .table td {
            max-width: 150px;
            /* Adjust as needed */
            white-space: normal !important;
            /* Allow text to wrap */
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word;
            /* Break long words */
        }
    }

    @media (max-width: 360px) {
        .card {
            margin-top: 70px;
            width: 350px;
        }

        .card-header {
            padding: 10px;
            font-size: 16px;
            /* Reduce font size for mobile */
            text-align: center;
        }

        .card-header h2 {
            font-size: 20px;
            /* Slightly smaller text */
        }
    }



    @media (max-width: 412px) {
        .card {
            margin-top: 70px;
        }


        .card-header {
            text-align: center;
            /* Keep text centered */
            padding: 12px;
            /* Adjust padding */
            font-size: 18px;
            /* Make text readable */
            border-radius: 10px 10px 0 0;
            /* Smooth rounded corners */
        }

        .card-header h2 {
            font-size: 22px;
            /* Slightly larger font for visibility */
        }
    }


    /* Remove sorting icons from table headers */
    #complaintTable thead th {
        pointer-events: none;
        /* Disable click events */
        background-image: none !important;
        /* Remove sorting icons */
        cursor: default !important;
        /* Prevent pointer cursor */
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
            display: block;
            /* Ensure it's visible */
            text-align: center;
            /* Center align for better mobile view */
            margin-bottom: 10px;
            /* Add some spacing */
        }
    }

    table#complaintTable thead th {
        background-color: #343a40;
        /* Dark background */
        color: white !important;
        /* Ensures white text */
    }


    .expandable-td {
        cursor: pointer;
        /* Show hand cursor */
    }

      .form-control {
        border: 1px solid #ccc !important; /* or any color you prefer */
        border-radius: 4px; /* optional: to keep the default rounded look */
    }
</style>
<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Reference Report</div>

    <div class="text-center mb-3">
        Total Amount: ₹ {{ number_format($totalAmount) }}
    </div>


    @php
    $allMonths = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
    ];
    @endphp
    <!-- Filter Dropdowns -->
    <form method="GET" action="{{ route('admin.references') }}">

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="month">Month</label>
                <select name="month" id="month" class="form-control">
                    <option value="">All</option>
                    @foreach($allMonths as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="year">Year</label>
                <select name="year" id="year" class="form-control">
                    <option value="">All</option>
                    @foreach($allYears as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="title">Title</label>
                <select name="title" id="title" class="form-control">
                    <option value="">All</option>
                    @foreach($allTitles as $title)
                    <option value="{{ $title }}" {{ request('title') == $title ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="reference_to">Referred To</label>
                <select name="reference_to" id="reference_to" class="form-control">
                    <option value="">All</option>
                    @foreach($allRefTo as $to)
                    <option value="{{ $to }}" {{ request('reference_to') == $to ? 'selected' : '' }}>{{ $to }}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </form>




    <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Industry</th>
                    <th>Referred By</th>
                    <th>Referred To</th>

                    <!-- <th>Title</th> -->
                    <th>Reference Details</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
                @foreach($references as $index => $reference)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reference->title }}</td>
                    <td>{{ $reference->referred_by }}</td>
                    <td>{{ $reference->referred_to }}</td>



                    <td class="expandable-td" data-full-text="{{ $reference->reference_details }}">
                        <span class="short-text">
                            {{ Str::limit($reference->reference_details, 20, '...') }}
                        </span>
                        <span class="full-text" style="display: none;">
                            {{ $reference->reference_details }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($reference->date)->format('F') }}</td>


                    <td>{{ \Carbon\Carbon::parse($reference->date)->format('Y') }}</td>
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
            </tbody>
        </table>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".expandable-td").forEach(function(td) {
                    td.addEventListener("click", function() {
                        // Close all expanded rows first
                        document.querySelectorAll(".expandable-td").forEach(function(otherTd) {
                            if (otherTd !== td) { // Exclude the clicked one
                                otherTd.querySelector(".full-text").style.display = "none";
                                otherTd.querySelector(".short-text").style.display = "inline";
                            }
                        });

                        // Toggle the clicked row
                        var shortText = this.querySelector(".short-text");
                        var fullText = this.querySelector(".full-text");

                        if (fullText.style.display === "none" || fullText.style.display === "") {
                            fullText.style.display = "inline";
                            shortText.style.display = "none";
                        } else {
                            fullText.style.display = "none";
                            shortText.style.display = "inline";
                        }
                    });
                });
            });
        </script>

    </div>
</div>
</div>


<!-- Custom Styling -->
<style>
    .table {
        background-color: white !important;
        /* Ensure table is white */
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd !important;
        /* Soft gray border */
    }

    .table thead {
        background-color: #ffffff !important;
        /* Dark header */
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
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<script>
    new DataTable('#complaintTable');
    $(document).ready(function() {
        $('#complaintTable').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            columnDefs: [{
                className: 'control',
                orderable: false,
                targets: -1
            }],
            paging: true,
            pageLength: 10,
            language: {
                lengthMenu: "Show MENU entries",
                emptyTable: "No rejected members found." // This message will be displayed when no data is available
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#complaintTable').DataTable();

        // Filter event handlers
        $('#filterMonth, #filterYear, #filterTitle, #filterTo').on('change', function() {
            let month = $('#filterMonth').val().toLowerCase();
            let year = $('#filterYear').val();
            let title = $('#filterTitle').val().toLowerCase();
            let referredTo = $('#filterTo').val().toLowerCase();

            table.rows().every(function() {
                var data = this.data();
                let show = true;

                if (month && !data[5].toLowerCase().includes(month)) show = false;
                if (year && data[6] != year) show = false;
                if (title && !data[1].toLowerCase().includes(title)) show = false;
                if (referredTo && !data[3].toLowerCase().includes(referredTo)) show = false;

                if (show) {
                    $(this.node()).show();
                } else {
                    $(this.node()).hide();
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Auto-submit on any filter change
        $('#month, #year, #title, #reference_to').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>


@endsection