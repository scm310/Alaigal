@extends('admin_layouts.app')
<!-- jQuery (Required for Bootstrap) -->
<!-- Remove one of these -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Bootstrap JS (Make sure it's included after jQuery) -->
<!-- Ensure Bootstrap JS is included once -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<style>
    /* Remove modal backdrop shadow */
    .modal-backdrop {
        display: none !important;
    }
    
    /* Ensure modal itself is still visible */
    .modal {
        background: none !important;
    }

      /* Hide sorting icons in table headers */
      table#example thead th {
                    background-image: none !important;
                    /* Remove the sort icons */
                    cursor: default !important;
                    /* Prevent pointer cursor */
                }

                /* Specifically target the DataTables sorting classes */
                table#example thead .sorting:after,
                table#example thead .sorting:before,
                table#example thead .sorting_asc:after,
                table#example thead .sorting_asc:before,
                table#example thead .sorting_desc:after,
                table#example thead .sorting_desc:before {
                    display: none !important;
                    /* Hide the sorting arrows */
                }
</style>


@section('content')
<div class="container">
    <h2>Quote Enquiries</h2>
    <table id="example" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
    <thead class="bg-primary">
        <tr>
            <th scope="col" style="color:white;text-align:center;">S.No</th>
            <th scope="col" style="color:white;text-align:center;">Date & Time</th>
            <th scope="col" style="color:white;text-align:center;">Product Name</th>
            <th scope="col" style="color:white;text-align:center;">Customer Name</th>
            <th scope="col" style="color:white;text-align:center;">Location</th>
            <th scope="col" style="color:white;text-align:center;">Phone</th>
            <th scope="col" style="color:white;text-align:center;">Email</th>
            <th scope="col" style="color:white;text-align:center;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($enquiries as $enquiry)
        <tr>
            <td>{{ $loop->iteration }}</td> <!-- To display the serial number -->
            <td>{{ $enquiry->created_at }}</td>
            <td>
                <a href="#" class="text-primary viewVendorDetails" data-id="{{ $enquiry->id }}">
                    {{ $enquiry->product_names ?? 'N/A' }}
                </a>
            </td>
            <td>{{ $enquiry->user_name }}</td>
            <td>{{ $enquiry->location }}</td>
            <td>{{ $enquiry->phone }}</td>
            <td>{{ $enquiry->email }}</td>
            <td>
                <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-info btn-sm" target="_blank">View Quote</a>
                <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete Quote</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<!-- Vendor Details Modal -->
<div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendorModalLabel">Vendor Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Vendor Name</th>
                        <td id="vendor_name"></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td id="vendor_phone"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="vendor_email"></td>
                    </tr>
                    <tr>
                        <th>GST No</th>
                        <td id="vendor_gst"></td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td id="vendor_company"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="vendor_address"></td>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <td id="vendor_product"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables & jQuery -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable(); // Initialize DataTable

        // When product name is clicked
        $('.viewVendorDetails').on('click', function(e) {
            e.preventDefault();
            let enquiryId = $(this).data('id');

            $.ajax({
                url: "{{ route('get.vendor.details') }}",
                type: "GET",
                data: { id: enquiryId },
                success: function(response) {
                    if (response.success) {
                        $('#vendor_name').text(response.vendor.vendor_name);
                        $('#vendor_phone').text(response.vendor.phone_number);
                        $('#vendor_email').text(response.vendor.email);
                        $('#vendor_gst').text(response.vendor.gst_no);
                        $('#vendor_company').text(response.vendor.company_name);
                        $('#vendor_address').text(response.vendor.address);
                        $('#vendor_product').text(response.vendor.product_name);
                        $('#vendorModal').modal('show');
                    } else {
                        alert('Vendor details not found.');
                    }
                },
                error: function() {
                    alert('Error fetching vendor details.');
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    $('.close, .modal').on('click', function() {
        $('#vendorModal').modal('hide');
    });

    // Prevent modal from closing when clicking inside it
    $('.modal-content').click(function(event){
        event.stopPropagation();
    });
});</script>


@endsection
