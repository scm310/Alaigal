@extends('admin_layouts.app')

@section('content')
<style>
    #success-message {
        width: 50%;
        margin: 0 auto;
    }

    /* Apply border to dropdown button */
    .dropdown-menu {
        border: 1px solid #ddd;
    }

    /* Fix dropdown position beside row */
    .dropdown-menu {
        position: absolute !important;
        transform: translateX(-100%) !important;
        /* Align beside action button */
        margin-left: 94% !important;
        /* Spacing */
        white-space: nowrap;
        background: linear-gradient(90deg, rgba(252, 252, 254, 1) 0%, rgba(244, 233, 249, 1) 35%, rgba(225, 205, 240, 1) 100%);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        margin-top: -55px !important;
    }

    /* Ensure each row positions correctly */
    tr {
        position: relative;
    }


    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;
    }

    /* Hide sorting icons in table headers */
    table#productTable thead th {
        background-image: none !important;
        cursor: default !important;
    }

    /* Specifically target the DataTables sorting classes */
    table#productTable thead .sorting:after,
    table#productTable thead .sorting:before,
    table#productTable thead .sorting_asc:after,
    table#productTable thead .sorting_asc:before,
    table#productTable thead .sorting_desc:after,
    table#productTable thead .sorting_desc:before {
        display: none !important;
    }

    input[type="text"] {
        text-align: center;
        /* Centers the text */
        width: 100%;
        /* Ensures input takes full width of the cell */
        box-sizing: border-box;
        /* Includes padding and border in width calculation */
    }


    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>New Vendor Products</b>

            </h4>





            <div class="card-header">

                @if(session('success'))
                <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productTable" class="table table-striped table-bordered" style="font-size: 0.875rem; width: 100%;">
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">S.No</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Product Name</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Vendor</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Category</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Vendor Price(₹)</th>

                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Date of Creation</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Status</th>
                                <th scope="col" style="color:white;font-size:small;text-transform:capitalize;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newVendorProducts as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> <a href="{{ route('items.show', $product->id) }}">
                                        {{ $product->productname  }}
                                    </a></td>
                                <td>{{ $product->company_name ?? 'N/A' }}</td>
                                <td>{{ $product->Category_name ?? 'N/A' }}</td>
                                <td>
                                    <!-- Set purchase price to readonly -->
                                    <input type="hidden" class="form-control form-control-sm"
                                        value="{{ $product->purchase_price ?? 0 }}" id="purchase_price{{ $product->id }}" readonly>
                                    ₹{{ number_format($product->purchase_price , 0, '', ',') }}
                                </td>
                                <td style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($product->created_at)->timezone('Asia/Kolkata')->format('d-m-Y h:i A') }}</td>

                                <td id="status_column_{{ $product->id }}" class="text-center" style="cursor: pointer;">
                                    @if($product->vendor_status == 'approved')
                                    <span class="badge bg-success" id="status_badge_{{ $product->id }}" title="Approved">A</span>
                                    @elseif($product->vendor_status == 'rejected')
                                    <span class="badge bg-danger" id="status_badge_{{ $product->id }}" title="Rejected">R</span>
                                    @else
                                    <span class="badge bg-warning text-dark" id="status_badge_{{ $product->id }}" title="Pending">P</span>
                                    @endif
                                </td>


                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            data-bs-display="static" aria-expanded="false">
                                            &#x22EE; <!-- 3-dot icon -->
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $product->id }}, 'approved')">Approve</a></li>
                                            <li><a class="dropdown-item d-none" href="#" onclick="updateStatus({{ $product->id }}, 'pending')">Pending</a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="updateStatus({{ $product->id }}, 'rejected')">Reject</a></li>
                                        </ul>
                                    </div>

                                </td>

                            </tr>

                            <!-- Modal for Product Details -->
                            <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="productModalLabel{{ $product->id }}">Product Details - {{ $product->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Product Name:</strong> {{ $product->name }}</p>
                                            <p><strong>Vendor Name:</strong> {{ $product->vendorDetails->vendor_name ?? 'N/A' }}</p>
                                            <p><strong>Category:</strong> {{ $product->category->Category_name ?? 'N/A' }}</p>
                                            <p><strong>Sales Price:</strong> ₹{{ number_format($product->sales_price, 2) }}</p>
                                            <img src="{{ asset('storage/app/public/' . $product->product_image) }}" alt="Product Image" class="img-fluid" style="max-height: 90px;">
                                            <p><strong>Created At:</strong> {{ $product->created_at }}</p>
                                            <p><strong>Status:</strong>
                                                {{ ucwords(str_replace('_', ' ', $notificationsStatus[$product->id] ?? 'pending')) }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>











        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "responsive": true, // Enable responsive behavior
            "pageLength": 10, // Default number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Dropdown for rows per page
            "ordering": true, // Enable column ordering
            "searching": true, // Enable global search
            "info": true, // Show table information (e.g., "Showing 1 to 10 of 100 entries")

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 10000);
        }
    });
</script>

<script>
    function updateMarginFromSales(productId) {
        var purchasePrice = parseFloat(document.getElementById('purchase_price' + productId).value);
        var salesPrice = parseFloat(document.getElementById('sales_price' + productId).value);

        if (!isNaN(purchasePrice) && !isNaN(salesPrice) && purchasePrice > 0) {
            var margin = ((salesPrice - purchasePrice) / purchasePrice) * 100;

            // Ensure margin is between 0 and 999
            margin = Math.max(0, Math.min(margin, 999));

            document.getElementById('fixing_of_margin' + productId).value = Math.round(margin);

            // Send the updated data to the server
            updateProductInDatabase(productId, margin, salesPrice);
        }
    }

    // Update Sales Price based on Margin and Purchase Price
    function updateSalesFromMargin(productId) {
        var purchasePrice = parseFloat(document.getElementById('purchase_price' + productId).value);
        var margin = parseFloat(document.getElementById('fixing_of_margin' + productId).value);

        if (!isNaN(purchasePrice) && !isNaN(margin) && purchasePrice > 0) {
            // Ensure margin is between 0 and 999
            margin = Math.max(0, Math.min(margin, 999));
            document.getElementById('fixing_of_margin' + productId).value = Math.round(margin);

            var salesPrice = purchasePrice * (1 + (margin / 100));
            document.getElementById('sales_price' + productId).value = Math.round(salesPrice);

            // Send the updated data to the server
            updateProductInDatabase(productId, margin, salesPrice);
        }
    }




    // Send updated product data to the server using AJAX
    function updateProductInDatabase(productId, margin, salesPrice) {
        $.ajax({
            url: '/update-product', // Define your route here
            type: 'POST',
            data: {
                product_id: productId,
                fixing_of_margin: margin,
                sales_price: salesPrice,
                _token: '{{ csrf_token() }}' // Add CSRF token for security
            },
            success: function(response) {
                console.log('Product updated successfully');
            },
            error: function(xhr, status, error) {
                console.log('Error updating product: ', error);
            }
        });
    }
</script>

<!-- status updation -->

<script>
    function updateStatus(productId, status) {
        console.log(productId);
        $.ajax({
            url: "{{ route('update.vendorproduct.status') }}", // Define this route in Laravel
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    // Update Status Column Text
                    $("#status_text_" + productId).text(status.charAt(0).toUpperCase() + status.slice(1));

                    // Update Badge Color & Text
                    let badge = $("#status_badge_" + productId);
                    badge.removeClass("bg-success bg-danger bg-warning text-dark");

                    if (status === "approved") {
                        badge.addClass("bg-success").text("A").attr("title", "Approved");
                    } else if (status === "rejected") {
                        badge.addClass("bg-danger").text("R").attr("title", "Rejected");
                    } else {
                        badge.addClass("bg-warning text-dark").text("P").attr("title", "Pending");
                    }
                } else {
                    alert("Failed to update status!");
                }
            },
            error: function() {
                alert("Something went wrong!");
            }
        });
    }
</script>



@endsection