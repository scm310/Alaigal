@extends('memberlayout.navbar')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<style>
@media (max-width: 768px) { /* Apply styles for tablets and mobile devices */
    .form-container {
        max-width: 100% !important;
        width: 100% !important;
        position: relative;
        top: 0;
    }

    .table-container {
        width: 100% !important;
    }

    .form-control {
        width: 100% !important; /* Ensure inputs take full width */
    }

    .btn {
        width: 100% !important; /* Ensure button takes full width */
    }
}
    /* General Styles */
    .container {
        overflow-x: hidden;
        /* Hide horizontal scroll */
        padding: 5px;
    }

    .form-container {
        width: 90%;
        max-width: 700px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-left: 30px;
        background-color: #d3cce3;
    }
    #ask {
        min-height: 60px;
        resize: vertical;
    }
    .form-control {
        border: 1px solid #c5c7c9;
        outline: none;
        transition: all 0.3s ease-in-out;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
    }

    .container-flex {
        display: flex;
        gap: 20px;
    }

    .left-column {
        width: 400px;
        flex-shrink: 0;
    }

    .card.form-container {
        width: 100%;
    }

    /* Table Styles */
    table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;


    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: left;
        font-size: 0.85rem;
        padding: 8px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .container-flex {
            flex-direction: column;
            margin-top: 20px;
        }

        .form-container {
            width: 95%;
            margin-left: 6px;
        }

        .table-container,
        .question-column,
        .question-column1 {
            max-width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }

    /* Tabs & Headers */
    .card-header {
        background-color: #f8f9fa;
        font-size: 1.25rem;
    }

    .nav-tabs .nav-item .nav-link {
        color: #fff;
        background: linear-gradient(to right, #bdc3c7, #2c3e50);
        border: 1px solid #ffffff;
    }

    .nav-tabs .nav-item .nav-link.active {
        background: linear-gradient(to right, #1d2b64, #f8cdda);


    }
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

       /* Adjust Table Column Width */
    #complaintTable th:nth-child(1),
    #complaintTable td:nth-child(1) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        max-width: 30px;
    }

    /* Adjust Table Column Width */
    #complaintTable th:nth-child(4),
    #complaintTable td:nth-child(4) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        max-width: 32px;
    }

    /* Adjust Table Column Width */
    #complaintTable th:nth-child(2),
    #complaintTable td:nth-child(2) {
        width: auto;
        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        max-width: 79px;
    }

    #complaintTable th:nth-child(3),
    #complaintTable td:nth-child(3) {
        width: auto;
        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        max-width: 100px !important;
    }

    /* Tabs Styling */
    .nav-tabs {
        margin-bottom: -47px;
        border-bottom: 0px solid #ddd;
        margin-left: 7px;
    }

    .tab-content {
        margin-top: -2px;
    }

    /* Round only the top-right corner of the first tab */
    .nav-tabs .nav-item:first-child .nav-link {
        border-top-right-radius: 10px;
    }

    /* Round only the top-right corner of the second tab */
    .nav-tabs .nav-item:last-child .nav-link {
        border-top-right-radius: 10px;
    }

    .question-column,
    .question-column2 {
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
    .question-column.expanded,
    .question-column2.expanded {
        height: auto;
        white-space: normal;
        word-wrap: break-word;
    }
    #complaintTable {
        border-radius: 10px;
        /* Rounded corners for the table */
        overflow: hidden;
        /* Ensures the table content respects the rounded corners */
        border-collapse: separate;
        /* Ensures corners are rounded */
        border-spacing: 0;
        /* Removes gaps between cells */
    }

                        @media (max-width: 768px) {
        .nav-tabs {
            margin-bottom: -15px;
        }

        .nav-tabs .nav-item {
            flex: 1 1 auto;
            text-align: center;
        }

        .nav-tabs .nav-link {
            white-space: nowrap;
            padding: 10px 15px;
            font-size: 14px;
            margin-top: 24px;
        }

        #complaintTable th:nth-child(1),
    #complaintTable td:nth-child(1) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        max-width:25px;
    }
}
</style>

<div class="container-fluid mt-4">
    <div class="container-wrapper">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">My Ask</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Others Ask</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Tab 1: My Ask -->
            <div class="tab-pane container-flex active" id="tab1">
                <div class="container-wrapper mt-5">
                    <div class="header">My Ask</div>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    @if (session('success'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: "{{ session('success') }}",
                                confirmButtonColor: '#866ec7',
                                confirmButtonText: 'OK',
                                width: '315px',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        });
                    </script>
                 
                    @endif

                    <!-- Form Section -->
                    <div class="container py-3 d-flex flex-column align-items-center">
                        <div class="card form-container p-4  mx-auto" style="max-width: 600px; width: 90%; position: relative; top: -16px;">
                            <h5 class="text-center mb-3" style="color:white;">Submit Your Ask</h5>
                            <form action="{{ route('ask.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                                        <input type="date" id="date" name="date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                                        <input type="text" id="ask" name="ask" class="form-control" style="margin-top:25px;" required placeholder="Type your question here..." maxlength="250" oninput="updateCounter()">
                                        <small id="charCount" class="text-muted">You can enter up to 0/250 characters</small>
                                    </div>
                                    <div class="col-md-2 col-12 text-center">
                                        <button type="submit" class="btn btn-primary w-98" style="font-size:13px; margin-left:-2px;">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Table Section -->
                        <div class="card table-container p-3 shadow" style="width: 90%; margin-top: 20px;">
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap" id="complaintTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Date</th>
                                            <th>Ask</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: #e7cfcf;">
                                        @foreach($asks as $index => $ask)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($ask->date)->timezone('Asia/Kolkata')->format('d-m-Y h:i A') }}</td>
                                            <td>
                                                <div class="question-column" onclick="toggleAsk(this, {{ $ask->id }})">
                                                    {{ $ask->my_ask }}
                                                </div>
                                            </td>
                                            <td>
                                                <form id="delete-form-{{ $ask->id }}" action="{{ route('ask.destroy', $ask->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $ask->id }})" style="border: none; background: none; padding: 2px;">
                                                        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Tab 2: Others Ask -->
         @include('my_ask.otherask')

        </div> <!-- End of tab-content -->
    </div> <!-- End of container-wrapper -->
</div> <!-- End of container-fluid -->

<script>
                                    let previousExpanded = null; // Track the previously expanded row

                                    function toggleAsk(element, askId) {
                                        // If there is a previously expanded row and it's not the current one, collapse it
                                        if (previousExpanded && previousExpanded !== element) {
                                            previousExpanded.classList.remove('expanded');
                                        }

                                        // Toggle the current row's expanded state
                                        element.classList.toggle('expanded');

                                        // Update the previousExpanded variable to the current element
                                        previousExpanded = element.classList.contains('expanded') ? element : null;
                                    }
                                </script>

<script>
    function updateCounter() {
        const input = document.getElementById('ask');
        const counter = document.getElementById('charCount');
        counter.textContent = `${input.value.length}/250`;
    }
</script>

<script>
    function loadPage(view, element) {
        // Highlight the active tab
        document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
        element.classList.add('active');

        fetch(`/load-content?view=${view}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('content-area').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<script>
    $(document).ready(function() {
        var isMobile = window.matchMedia("(max-width: 768px)").matches; // Detect mobile devices

        $('#complaintTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": false,
            "autoWidth": false,
            "columnDefs": isMobile ? [
                { "className": "all", "targets": 0 },  // Ensure the first column is always visible
                { "className": "none", "targets": [1, 2] } // Hide columns 1 & 2 on mobile
            ] : [] // No column hiding on larger screens
        });
    });
</script>

<script>
    $(document).ready(function () {
        function initializeDataTable() {
            var isMobile = window.innerWidth <= 768; // Detect mobile screen size
            var options = {
                "responsive": true,
                "paging": true,
                "searching": true,
                "ordering": false,
                "autoWidth": false,
            };

            // Apply column hiding only for mobile screens
            if (isMobile) {
                options.columnDefs = [
                    { "className": "all", "targets": 0 }, // Ensure first column is visible
                    { "className": "none", "targets": [1, 2] } // Hide columns 1 & 2 on mobile
                ];
            }

            // Destroy existing DataTable (if any) before reinitializing
            if ($.fn.DataTable.isDataTable("#complaintTable")) {
                $('#complaintTable').DataTable().destroy();
            }

            // Initialize DataTable
            $('#complaintTable').DataTable(options);
        }

        // Initialize DataTable on page load
        initializeDataTable();

        // Reinitialize on window resize to adjust for screen changes
        $(window).resize(function () {
            initializeDataTable();
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
            confirmButtonColor: "#BE6CFD",
            cancelButtonColor: "#B2BEB5",
            confirmButtonText: "Yes, delete it!",

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
</script>
@endsection