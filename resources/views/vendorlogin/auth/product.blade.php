@extends('vendor_layouts.app')

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Popper.js (needed for dropdown functionality in Bootstrap 5) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>



<style>
    .dropdown-menu.show {
    background: linear-gradient(90deg, rgba(252, 252, 254, 1) 0%, rgba(244, 233, 249, 1) 35%, rgba(225, 205, 240, 1) 100%);
    min-width: 102px !important; /* Force the width */
    max-width: 80px !important; /* Prevent expansion */
    width: 150px !important; /* Apply width restriction */
    transform: translateX(-105%) translateY(-77%) !important; /* Move dropdown upwards */
    top: auto !important;

}

    .edit {
        color: blue !important;
    }

    .view {
        color: lightsalmon;
    }

    /* Hide sorting icons in table headers */
    table#vendorTable thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */
    table#vendorTable thead .sorting:after,
    table#vendorTable thead .sorting:before,
    table#vendorTable thead .sorting_asc:after,
    table#vendorTable thead .sorting_asc:before,
    table#vendorTable thead .sorting_desc:after,
    table#vendorTable thead .sorting_desc:before {
        display: none !important;
        /* Hide the sorting arrows */
    }

    .header {
    background: linear-gradient(to right, #5a6c8e, #b180c7);
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.table thead th{
    font-size:12.5px;
}
.table>tbody {
    font-size: 13px;
}
</style>

@section('title', 'Vendor Dashboard')

@section('content1')
<!-- Vendor content section -->

<!-- Check for success message and show Popup -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Check for success message and show Popup -->

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif

<!-- Table for displaying Products -->
<div class="card">
    <div class="card-body">
        <h3 class="header">Your Products</h3>
        <style>
    /* Hide the extra row by default */
    .hidden-row {
        display: none;
        background-color: #f9f9f9;
    }

    /* Expand/Collapse button styling (only in mobile view) */
    @media (max-width: 768px) {
        .details-control {
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            width: 30px;
        }

        /* Hide extra columns in mobile view */
        .desktop-columns {
            display: none;
        }
    }


    @media (min-width: 768px) { /* Hide on desktop */
    .mobile-only {
        display: none !important;
    }
}


</style>
<div class="table-responsive">
    <table id="example" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
        <thead>
            <tr>
           
                  <th class="mobile-only">+</th> <!-- Expand Button (Only for Mobile) -->
                <th>S.No</th>
                <th>Product Name</th>
                <th class="desktop-columns">Brand</th>
                <th class="desktop-columns">Main Category</th>
                <th class="desktop-columns">Sub Category</th>
                <th class="desktop-columns">Child Category</th>
                <th class="desktop-columns">Sales Price</th>
                <th class="desktop-columns">Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isEmpty())
                <tr>
                    <td colspan="10" class="text-center text-muted">No Data Found</td>
                </tr>
            @else
                @foreach ($products as $product)
                <tr>
                <td class="details-control mobile-only" data-id="{{ $product->id }}">+</td> 
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="desktop-columns">{{ $product->brand ?? 'N/A' }}</td>
                    <td class="desktop-columns">{{ $product->category->Category_name ?? 'N/A' }}</td>
                    <td class="desktop-columns">{{ $product->subcategory->name ?? 'N/A' }}</td>
                    <td class="desktop-columns">{{ $product->childcategory->name ?? 'N/A' }}</td>
                    <td class="desktop-columns">
                        {{ preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($product->purchase_price, 0, -3)) . 
                        (strlen($product->purchase_price) > 3 ? ',' : '') . substr($product->purchase_price, -3) }}
                    </td>
                    <td class="desktop-columns">
                        {{ $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('d-m-Y') : 'N/A' }}
                    </td>
                    <td>
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('vendor.products.view', $product->id) }}" class="dropdown-item">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('vendor.products.edit', $product->id) }}" class="dropdown-item">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('vendor.products.delete', $product->id) }}" method="POST" onsubmit="return confirmDelete(event);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                <!-- Hidden Row for Extra Details (Mobile Only) -->
                <tr class="hidden-row mobile-only" id="details-{{ $product->id }}">
                    <td colspan="10">
                        <strong>Brand:</strong> {{ $product->brand ?? 'N/A' }}<br>
                        <strong>Main Category:</strong> {{ $product->category->Category_name ?? 'N/A' }}<br>
                        <strong>Sub Category:</strong> {{ $product->subcategory->name ?? 'N/A' }}<br>
                        <strong>Child Category:</strong> {{ $product->childcategory->name ?? 'N/A' }}<br>
                        <strong>Sales Price:</strong>                   {{ preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($product->purchase_price, 0, -3)) . 
                        (strlen($product->purchase_price) > 3 ? ',' : '') . substr($product->purchase_price, -3) }}<br>
                        <strong>Expiry Date:</strong> {{ $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('d-m-Y') : 'N/A' }}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll(".details-control");

        rows.forEach(row => {
            row.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                const detailsRow = document.getElementById("details-" + productId);

                if (detailsRow) {
                    if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
                        detailsRow.style.display = "table-row"; // Show details
                        this.textContent = "-"; // Change + to -
                    } else {
                        detailsRow.style.display = "none"; // Hide details
                        this.textContent = "+"; // Change - to +
                    }
                }
            });
        });
    });
</script>

    </div>
</div>

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
    function confirmDelete(event) {
        event.preventDefault(); // Prevent form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this product ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(177, 96, 248)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Submit form if confirmed
            }
        });
    }
</script>

<script>
    function moneyFormatIndia($num) {
    $exploded = explode('.', $num);
    $intPart = $exploded[0];
    $decimalPart = isset($exploded[1]) ? '.' . $exploded[1] : '';

    $intPart = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $intPart);
    return $intPart . $decimalPart;
}

</script>

@endsection