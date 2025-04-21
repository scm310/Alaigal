@extends('admin_layouts.app')


<style>
    .footer {
        background-color: #f8f9fa;
        padding: 1rem 0;
        margin-top: 285px;
    }

    .expand {
    display: inline-block;
    max-width: 390px;
    height: auto;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    padding: 5px;
    text-align: left;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

/* Expanded state */
.expand.expanded {
    white-space: normal;
    word-wrap: break-word;
    overflow: visible;
}



</style>

@section('content')
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>Manage Enquiries</b> <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a></h4>




            <!-- Table -->
            <table id="example" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Name</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Email</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Message</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Phone</th>

                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiries as $occupantsTable)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $occupantsTable->name }}</td>
                        <td>{{ $occupantsTable->email }}</td>
                        <td>
    <div class="expand"
        title="{{ strlen($occupantsTable->message) > 30 ? 'Click to view the message' : '' }}"
        onclick="toggleExpand(this)"
        data-full-message="{{ $occupantsTable->message }}"
        style="cursor: pointer; max-width: 200px; word-wrap: break-word; white-space: normal; overflow-wrap: break-word;">
        {{ strlen($occupantsTable->message) > 30 ? substr($occupantsTable->message, 0, 30) . '...' : $occupantsTable->message }}
    </div>
</td>





                        <td>{{ $occupantsTable->phone }}</td>
                        <td>{{ \Carbon\Carbon::parse($occupantsTable->created_at)->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A') }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>




        </div>


    </div>
</div>

<script>
    function toggleExpand(element) {
        let fullMessage = element.getAttribute("data-full-message");

        if (element.innerText.length > 30) {
            if (element.classList.contains("expanded")) {
                // Collapse the message
                element.innerText = fullMessage.substring(0, 30) + "...";
                element.classList.remove("expanded");
            } else {
                // Expand the message
                element.innerText = fullMessage;
                element.classList.add("expanded");
            }
        }
    }
</script>

<!-- script section -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<!-- Dynamic Subcategory Loading -->

<script>
    $(document).ready(function() {
        // Initialize the DataTable
        $('#vendorTable').DataTable({
            "responsive": true, // Makes the table responsive for mobile screens
            "pageLength": 10, // Set the default number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Options for rows per page
            "ordering": true, // Enable column ordering
            "searching": true, // Enable search functionality
            "info": true, // Display information about the table (e.g., showing entries 1 to 10 of 50)
        });
    });
</script>
<script>
function toggleExpand(element) {
    const fullMessage = element.getAttribute("data-full-message");
    
    if (element.classList.contains("expanded")) {
        // Collapse the message
        element.innerText = fullMessage.substring(0, 30) + "...";
        element.classList.remove("expanded");
    } else {
        // Expand the message
        element.innerText = fullMessage;
        element.classList.add("expanded");
    }
}

</script>


@endsection