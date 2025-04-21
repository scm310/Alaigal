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
        background: linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%);
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
    .alert-success{
        width:318px;
        margin-left:377px;
        background: linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%);
        color: white;
    }

 
    .print-btn {
      padding: 5px 20px;
      background: linear-gradient(45deg, #6a11cb, #2575fc);
      border: none;
      border-radius: 50px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .print-btn:hover {
      opacity: 0.9;
      transform: scale(1.05);
    }


    </style>
   <div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">ThanksNote Report</div>

    <div class="alert alert-success text-center mt-3" role="alert">
        <strong>Total Thanks Note Amount:</strong> ₹
        @php
            $num = (int) $totalAmount;
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
    </div>


    <form method="GET" action="{{ url()->current() }}" id="filterForm" class="mb-3">
        <div class="border p-3 rounded shadow-sm" style="background-color: #f8f9fa;">
            <div class="row g-3 align-items-end">

<!-- Total Amount Display -->


                {{-- Year Filter --}}
                <div class="col-md-2">
                    <label for="year"><strong>Year</strong></label>
                    <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                        <option value="">All Years</option>
                        @foreach(range(date('Y'), 2020) as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Month Filter --}}
                <div class="col-md-2">
                    <label for="month"><strong>Month</strong></label>
                    <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                        <option value="">All Months</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

               {{-- Company Name Filter --}}
               <div class="col-md-2">
                <label for="company_name"><strong>Company Name</strong></label>
                <select name="company_name" id="company_name" class="form-control" onchange="this.form.submit()">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->company_name }}" {{ request('company_name') == $company->company_name ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="member_id"><strong>Thanksnote Given To</strong></label>
                <select name="member_id" id="member_id" class="form-control js-member-select">
                    <option value="">All Members</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}"
                        data-image="{{ asset('storage/' . $member->profile_photo) }}"
                        {{ request('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->first_name }} {{ $member->last_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button class="print-btn" onclick="printTable()">Export PDF</button>

            </div>
            
            </div>
        </div>
    </form>

    <script>
        function printTable() {
          const table = document.getElementById("complaintTable").outerHTML;
          const win = window.open('', '', 'height=700,width=900');
          win.document.write('<html><head><title>Print Table</title>');
          win.document.write('<style>table { width: 100%; border-collapse: collapse; } table, th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
          win.document.write('</head><body>');
          win.document.write(table);
          win.document.write('</body></html>');
          win.document.close();
          win.print();
        }
      </script>
  

    <!-- Table -->
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Thanks Note From</th>
                    <th>Thanks Note To</th>
                    <th>Thanks Note Title</th>
                    <th>Thanks Note Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody style="background-color: #e7cfcf;">
                @foreach($thanksNotes as $index => $thanksNote)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $thanksNote->name }}</td>
                    <td>{{ $thanksNote->thanks_to }}</td>
                    <td>{{ $thanksNote->thanksnote_title }}</td>
                    <td>₹
                        @php
                            $num = (int) $thanksNote->thanksnote_amount;
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
                    <td>{{ \Carbon\Carbon::parse($thanksNote->date)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Auto-submit script -->
<script>
    document.getElementById('year').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
    document.getElementById('month').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
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


