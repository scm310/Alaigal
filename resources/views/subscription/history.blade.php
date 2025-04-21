@extends('memberlayout.navbar')

@section('content')

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">


<style>
    .payment-container {
        background-color: #ffffff;
        border-radius: 10px;
        max-width: 900px;
        margin: auto;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        padding: 20px;
        margin-top: 20px;
        overflow: hidden;
    }

    .payment-header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        font-weight: bold;
        font-size: 22px;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }


    .tooltip-container {
        display: none;
        position: absolute;
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
        width: 220px;
        z-index: 100;
        text-align: left;
        font-size: 14px;
        border: 1px solid #ccc;
    }

    .tooltip-container::before {
        content: "";
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 6px;
        border-style: solid;
        border-color: transparent transparent #ccc transparent;
    }

    .close-tooltip {
        display: block;
        text-align: right;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        color: red;
    }

    .expand-btn {
        cursor: pointer;
        color: #1d2b64;
        font-weight: bold;
        font-size: 18px;
        border: none;
        background: none;
    }

    .expand-btn:focus {
        outline: none;
    }

    .paid-status {
        font-weight: bold;
        color: green;
    }

    .unpaid-status {
        font-weight: bold;
        color: red;
    }

    .download-btn {
        display: inline-block;
        margin-top: 5px;
        background-color: #343a40;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
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

table#paymenthistory thead th {
    background-color: #343a40; /* Dark background */
    color: white !important; /* Ensures white text */
}


/* Remove sorting icons from table headers */
#paymenthistory thead th {
    pointer-events: none; /* Disable click events */
    background-image: none !important; /* Remove sorting icons */
    cursor: default !important; /* Prevent pointer cursor */
}

/* Specifically target DataTables sorting classes */
#paymenthistory thead .sorting,
#paymenthistory thead .sorting_asc,
#paymenthistory thead .sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

/* Hide sorting arrows */
#paymenthistory thead .sorting:after,
#paymenthistory thead .sorting:before,
#paymenthistory thead .sorting_asc:after,
#paymenthistory thead .sorting_asc:before,
#paymenthistory thead .sorting_desc:after,
#paymenthistory thead .sorting_desc:before {
    display: none !important;
}


/* Ensure proper responsiveness */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
}
</style>

<div class="container mt-4">
    <div class="payment-container">
        <div class="payment-header">Payment History</div>
        <div class="table-responsive">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="paymenthistory" style="width:100%;">
            <thead class="bg-light">
                    <tr>
                        <th class="text-center">Subscription Type</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Start Date</th>
                        <th class="text-center">End Date</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->plan_type }}</td>
                        <td>{{ $subscription->duration }} Months</td>
                        <td>₹{{ $subscription->amount }}</td>
                        <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d M, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d M, Y') }}</td>
                        <td class="{{ $subscription->payment_status == 1 ? 'paid-status' : 'unpaid-status' }}">
                            {{ $subscription->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                            @if($subscription->payment_status == 1)
                                <br>
                                <a href="{{ route('subscription.invoice', $subscription->id) }}" class="download-btn" target="_blank">Download Invoice</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- <div class="table-responsive mobile-view">
            <table class="table table-bordered payment-table">
                <thead>
                    <tr>
                        <th>+</th>
                        <th>Subscription Type</th>
                        <th>Duration</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>
                            <button class="expand-btn" onclick="showTooltip(this, '{{ \Carbon\Carbon::parse($subscription->start_date)->format('d M, Y') }}', '{{ \Carbon\Carbon::parse($subscription->end_date)->format('d M, Y') }}', '{{ $subscription->payment_status == 1 ? 'Paid' : 'Unpaid' }}')">+</button>
                            @if($subscription->payment_status == 1)
                                <a href="{{ route('subscription.invoice', $subscription->id) }}" class="download-btn" target="_blank">Invoice</a>
                            @endif
                        </td>
                        <td>{{ $subscription->plan_type }}</td>
                        <td>{{ $subscription->duration }} Months</td>
                        <td>₹{{ $subscription->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> -->
    </div>
</div>

<!-- <div id="tooltip" class="tooltip-container">
    <span class="close-tooltip" onclick="hideTooltip()">✖</span>
    <p><strong>Start Date:</strong> <span id="tooltip-start-date"></span></p>
    <p><strong>End Date:</strong> <span id="tooltip-end-date"></span></p>
    <p><strong>Status:</strong> <span id="tooltip-status"></span></p>
</div> -->

<script>
    function showTooltip(button, startDate, endDate, status) {
        let tooltip = document.getElementById("tooltip");
        document.getElementById("tooltip-start-date").innerText = startDate;
        document.getElementById("tooltip-end-date").innerText = endDate;
        document.getElementById("tooltip-status").innerText = status;

        let rect = button.getBoundingClientRect();
        tooltip.style.top = window.scrollY + rect.top + 30 + "px";
        tooltip.style.left = rect.left + "px";
        tooltip.style.display = "block";
    }

    function hideTooltip() {
        document.getElementById("tooltip").style.display = "none";
    }

    document.addEventListener("click", function(event) {
        let tooltip = document.getElementById("tooltip");
        if (!event.target.closest(".expand-btn") && !event.target.closest("#tooltip")) {
            tooltip.style.display = "none";
        }
    });
</script>


<!-- DataTables Initialization -->
<script>
$(document).ready(function () {
    $('#paymenthistory').DataTable({
        responsive: true,
        paging: true,
        pageLength: 10,
        language: {
            lengthMenu: "Show MENU entries",
            emptyTable: "No Thanksnotes given yet."
        }
    });

    // Enable Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
@endsection
