@extends('admin_layouts.app')

@section('content')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<style>
    #productTable_filter>label>input[type=search] {
        margin-bottom: 10px;
        margin-top: 3px;
    }

    /* Optional customization for Bootstrap tooltips */
    .tooltip-inner {
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
    }

    .tooltip-arrow {
        border-top-color: rgba(0, 0, 0, 0.7);
    }

    /* Apply border to the table */
    #vendorTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    /* Apply border to table header */
    #vendorTable th {
        border: 1px solid #ddd;
        padding: 8px;
        background-color: #f8f9fa;
        text-align: center;
    }

    /* Apply border to table cells */
    #vendorTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Apply border to dropdown button */
    .dropdown-menu {
        border: 1px solid #ddd;
    }

    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;
    }

    /* Hide sorting icons in table headers */
    table#productTable thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */
    table#productTable thead .sorting:after,
    table#productTable thead .sorting:before,
    table#productTable thead .sorting_asc:after,
    table#productTable thead .sorting_asc:before,
    table#productTable thead .sorting_desc:after,
    table#productTable thead .sorting_desc:before {
        display: none !important;
        /* Hide the sorting arrows */
    }

    .comparison-header {
        display: flex;
        align-items: center;
        /* Vertically align items */
        justify-content: space-between;
        /* Distribute space between title and tabs */
        margin-bottom: 20px;
    }

    .comparison-title {
        border: 2px solid #ddd;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .tabs {
        display: flex;
        gap: 10px;
        /* Space between tabs */
    }

    .tab {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        cursor: pointer;
        font-weight: bold;
        font-size: 1rem;
        text-align: center;
        min-width: 100px;
        /* Ensure consistent size for tabs */
        text-overflow: ellipsis;
    }

    .tab.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #f1f1f1;
    }


    .comparison-title {
        border: 2px solid #ddd;
        /* Border around the title */
        padding: 10px 15px;
        /* Add spacing inside the border */
        border-radius: 5px;
        /* Rounded corners */
        background-color: #f9f9f9;
        /* Light background color */
        text-align: center;
        /* Center-align the title */
        margin-bottom: 20px;
        /* Space below the title */
        /* font-weight: bold; Make the title bold */
        font-size: 1.2rem;
        /* Adjust font size */
    }

    .comparison-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .comparison-card .card-title {
        font-weight: bold;
        margin-bottom: 1rem;
    }


    #suggestions {
        top: calc(100% + 5px);
        /* Place the suggestion box just below the search bar */
        left: 0;
        /* Align to the left of the search field */
        max-width: 70%;
        /* Ensure it aligns with the search bar width */
        background-color: #fff;
        /* Background for better visibility */
        border: 1px solid #ddd;
        /* Add border for distinction */
        border-radius: 5px;
        /* Rounded corners */
    }

    .modal-backdrop {
        width: 2000vw !important;
        /* Increase width (120% of viewport width) */
        height: 200vh !important;
        /* Increase height (120% of viewport height) */
        background-color: rgba(0, 0, 0, 0.5) !important;
        /* Optional: Adjust opacity */
        position: absolute !important;
        /* Ensure proper positioning */
        top: 150% !important;
        /* Center vertically */
        left: 200% !important;
        /* Center horizontally */
        transform: translate(-100%, -100%) !important;
        /* Ensure it's centered */

    }

    .dropdown-menu.show {
        background: linear-gradient(90deg, rgba(252, 252, 254, 1) 0%, rgba(244, 233, 249, 1) 35%, rgba(225, 205, 240, 1) 100%);
        transform: translateX(870px) !important;
        margin-top: 73px;
    }

    .edit {
        color: blue !important;
    }

    .view {
        color: lightsalmon;
    }

    .highlight {
        color: green;
    }

    .close:hover {
        background-color: grey !important;
    }

    th {
        background-color: #A87676;
        /* Set background color */
        color: white;
        /* Set text color to white */
        text-transform: capitalize !important;
        /* Apply Pascal case formatting */
    }

    .btn {
        text-transform: capitalize !important;
    }

    td {
        word-wrap: break-word;
        white-space: normal;
        max-width: 200px;
        /* Adjust the width as needed */
        overflow-wrap: break-word;
    }


    td {
        word-wrap: break-word;
        white-space: normal;
        max-width: 200px;
        /* Adjust the width as needed */
        overflow-wrap: break-word;
    }

    .product-image {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
        /* Smooth transition */
    }

    .product-image:hover {
        transform: scale(2.5);
        /* Increase size by 1.5 times */
    }
</style>
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <div class="row">
                <div class="col-4">
                    <h4><b>Highlight Product</b></h4>
                </div>



            </div>


            <div class="card-header d-flex justify-content-end align-items-center">

                @if(session('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif


            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="container ">

                        <!-- Comparison Results Container -->
                        <div class="comparison-container mt-4" style="display: none;">
                            <h4 style="text-align: center;">Comparison Results</h4>
                            <div id="compareContainer" class="row position-relative"></div>
                        </div>
                        <div class="row">

                            <div class="table-responsive">
                                <!-- Products Table -->
                                <table id="productTable" style="width:100%" class="table table-striped table-bordered ">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Product Name</th>
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Brand / Group</th>
                                            <!--<th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Company</th>-->
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Product Image</th>
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Expiry Date</th>
                                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                                                <a href="{{ route('items.show', $item->id) }}"
                                                    title="{{ strlen($item->name) > 25 ? $item->name : '' }}">
                                                    {{ $item->item_name }}
                                                </a>
                                            </td>


                                            <td>{{ $item->brand  ?? 'N/A'}}</td>
                                            <!--<td>{{ $item->company_name ?? 'N/A' }}</td>-->
                                            <td>
                                                <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid product-image" style="max-width: 100px; max-height: 100px; object-fit: cover;" data-toggle="modal" data-target="#imageModal" data-image="{{ asset('storage/' . $item->product_image) }}">
                                            </td>
                                            <td>{{ $item->expiration_date ? \Carbon\Carbon::parse($item->expiration_date)->format('d-m-Y') : 'N/A' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-link p-0 text-dark highlight"
                                                    data-toggle="modal"
                                                    data-target="#highlightModal"
                                                    data-product-id="{{ $item->id }}"
                                                    data-product-name="{{ $item->name }}">
                                                    <i class="fas fa-star"></i> Highlight Product
                                                </button>
                                                <!-- @foreach($highlights as $highlight)
                                                <p>{{ $highlight->name }}</p>
                                                @endforeach -->

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






            @include('items.highlight')

            <!-- Modal for Product Details -->
            @foreach ($items as $item)
            <div class="modal fade" id="productModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel{{ $item->id }}">{{ $item->name }} - Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Product Details Section -->
                            <h6 style="font-weight:800; color:black;">Primary Product Details</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-3 d-flex align-items-center">
                                        @if ($item->product_image)
                                        <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid" style="max-height: 90px;">
                                        @else
                                        <img src="{{ asset('default-image.jpg') }}" alt="Default Product Image" class="img-fluid" style="max-height: 90px;">
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-12 d-flex">
                                                <strong>Product Name:</strong>
                                                <div class="ms-2">{{ $item->name }}</div>
                                            </div>
                                            <div class="col-12 d-flex">
                                                <strong>Product ID:</strong>
                                                <div class="ms-2">{{ $item->product_id }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price and Tax Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Price and Tax Details</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Sales Price:</strong>
                                        <div class="ms-2">â‚¹{{ number_format($item->sales_price) }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Purchase Price:</strong>
                                        <div class="ms-2">â‚¹{{ number_format($item->purchase_price) }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Tax:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax . '%' : 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Expiration Date:</strong>
                                        <div class="ms-2">
                                            {{ $item->expiration_date ? \Carbon\Carbon::parse($item->expiration_date)->format('d-m-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>CGST:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax/2 . '%' : 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>SGST:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax/2 . '%' : 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vendor Information -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Vendor Information</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Vendor Name:</strong>
                                        <div class="ms-2">{{ $item->vendor_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Email:</strong>
                                        <div class="ms-2">{{ $item->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Contact:</strong>
                                        <div class="ms-2">{{ $item->phone_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specifications Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Specifications</h6>
                            <div class="product custom-shadow">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="font-weight:900; color:#89868d; text-transform: capitalize; font-size:small">Specification Name</th>
                                            <th style="font-weight:900; color:#89868d; text-transform: capitalize; font-size:small">Specification Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($item->specification_name && $item->specification_value)
                                        @php
                                        $specValue1 = json_decode($item->specification_name, true);
                                        $specValue = json_decode($item->specification_value, true);
                                        @endphp
                                        @if(is_array($specValue1))
                                        @foreach ($specValue1 as $i => $specName)
                                        <tr>
                                            <td><b>{{ $specName ?? 'Unknown' }}</b></td>
                                            <td>{{ $specValue[$i] ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @else
                                        <tr>
                                            <td colspan="2">No specifications available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Categories Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Categories</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Main Category:</strong>
                                        <div class="ms-2">{{ $item->category_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Subcategory:</strong>
                                        <div class="ms-2">{{ $item->subcategory_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Child Category:</strong>
                                        <div class="ms-2">{{ $item->child_category_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</div>


<!-- script section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // Fade after 3 seconds
        }
    });

    $('button[data-toggle="modal"]').on('click', function() {
        console.log('Modal button clicked!');
    });
</script>


<script>
    $(document).ready(function() {
        // Initialize the DataTable
        $('#productTable').DataTable({
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
    function updateFileName() {
        var input = document.getElementById('fileInput');
        var fileNameDisplay = document.getElementById('fileName');

        if (input.files.length > 0) {
            fileNameDisplay.textContent = "Selected File: " + input.files[0].name;
            fileNameDisplay.style.display = "inline";
        } else {
            fileNameDisplay.style.display = "none";
        }
    }
</script>


@endsection