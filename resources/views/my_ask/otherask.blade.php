<style>
       .headers {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
        margin-top: -8px !important;
        width: 101%;
        margin-left: -8px;
    }

  /* Hide sorting icons in table headers */
  table#complaintTable thead th,
    table#allask thead th {

        background-color: #343a40;
        color: white;

    }

    table#complaintTable tbody th,
    table#allask tbody th {

        background-color: #e7cfcf;
        color: rgb(12, 12, 12);

    }

    
    table#complaintTable thead .sorting:after,
    table#complaintTable thead .sorting:before,
    table#allask thead .sorting:after,
    table#allask thead .sorting:before,
    table#allask thead .sorting_asc:after,
    table#allask thead .sorting_asc:before,
    table#allask thead .sorting_desc:after,
    table#allask thead .sorting_desc:before {
        display: none !important;
    }


        #allask th:nth-child(5),
    #allask td:nth-child(5) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        width: 42px !important;
    }

    #allask th:nth-child(1),
    #allask td:nth-child(1) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        width: 0px !important;
    }

    #allask th:nth-child(2),
    #allask td:nth-child(2) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        width: 16px !important;
    }

    #allask th:nth-child(3),
    #allask td:nth-child(3) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        width: 18px !important;
    }

    #allask th:nth-child(4),
    #allask td:nth-child(4) {

        word-wrap: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        width: 5px !important;
    }
    
    .question-column2 {
                        cursor: pointer;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        max-width: 200px;
                        /* Adjust as needed */
                        transition: max-height 0.3s ease-in-out;
                    }

                    .question-column2.expanded {
                        white-space: normal;
                        overflow: visible;
                        max-width: none;
                    }

    @media (max-width: 768px) {

        table#complaintTable tbody th,
    table#allask tbody th {

        background-color: #e7cfcf;
        color: rgb(12, 12, 12);
        font-size:12px !important;

    }

    table#complaintTable thead th, table#allask thead th{
        font-size:9px ;
    }}

</style>


<div class="tab-pane container-flex" id="tab2">
                <div class="container-wrapper mt-5 p-4 bg-white shadow rounded">
                    <div class="headers">Others Ask</div>
                    <div class="card-body table-container">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered dt-responsive nowrap" id="allask" style="width: 100%;">
                                <thead class="bg-light">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Ask</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #e7cfcf;">
                                    @foreach ($allAsks as $index => $ask)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ask->created_at)->format('d-m-Y h:i A') }}</td>
                                        <td>
                                            @if($ask->member)
                                            {{ $ask->member->first_name }} {{ $ask->member->last_name }}
                                            @else
                                            Unknown User
                                            @endif
                                        </td>
                                        <td>
                                            @if($ask->member)
                                            {{ $ask->member->phone_number }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            <div class="question-column2">
                                                {{ $ask->my_ask }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- JavaScript for Single Expansion -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let expandedTd = null; // Keep track of the currently expanded td

                        document.querySelectorAll(".question-column2").forEach(td => {
                            td.addEventListener("click", function() {
                                // If another td is open, close it
                                if (expandedTd && expandedTd !== this) {
                                    expandedTd.classList.remove("expanded");
                                }

                                // Toggle current td
                                this.classList.toggle("expanded");

                                // Update the expandedTd reference
                                expandedTd = this.classList.contains("expanded") ? this : null;
                            });
                        });
                    });
                </script>


            </div>
<script>
    $(document).ready(function () {
        function initializeAllAskTable() {
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
                    { "className": "all", "targets": 0 }, // Ensure first column is always visible
                    { "className": "none", "targets": [1, 2, 3] } // Hide columns 1, 2, and 3 on mobile
                ];
            }

            // Destroy existing DataTable (if any) before reinitializing
            if ($.fn.DataTable.isDataTable("#allask")) {
                $('#allask').DataTable().destroy();
            }

            // Initialize DataTable
            $('#allask').DataTable(options);
        }

        // Initialize DataTable on page load
        initializeAllAskTable();

        // Reinitialize on window resize to adjust for screen changes
        $(window).resize(function () {
            initializeAllAskTable();
        });
    });
</script>