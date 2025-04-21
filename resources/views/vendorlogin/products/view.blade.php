@extends('vendor_layouts.app')

@section('title', 'Product Details - ' . $product->name)

@section('content1')

<style>
    .btn {
        background-color:rgb(145, 81, 229) ;
    }
    /* .btn:hover{
        background-color:rgb(145, 81, 229) ;
        color:white!important;
    } */
    
    
    /* Box Shadow for the whole row div */
.product-row {
    transition: box-shadow 0.3s ease;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
    border-radius: 10px;
    height:140px;
}

/* Zoom effect for the image inside the div */
.product-image-container img {
    max-height:120px !important; /* Keeps the height fixed */
    transition: transform 0.3s ease;
    cursor: zoom-in;
    border-radius: 10px;
    margin-left:30px;
}

/* Zoom effect when hovering over the image */
.product-image-container img:hover {
    transform: scale(1.3); /* Slight zoom effect on hover */
}

/* Box shadow effect on the row div when hovered */
.product-row:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
}


.container{
    margin-bottom: 30px;
 margin-left:-35px;
 font-size: 13px;
}


.modal-content {
    margin-top: 60px;
}
@media (max-width: 768px) {
    /* Make the product row stack items vertically */
    .product-row {
        flex-direction: column;
        height: auto;
        text-align: center;
        padding: 15px;
    }

    /* Center and resize the product image */
    .product-image-container img {
        max-width: 100%;
        height: auto;
        margin: 10px auto;
        display: block;
    }

    /* Adjust column layout */
    .col-md-4 {
        width: 100%;
        text-align: center;
        margin-bottom: 15px;
    }

    /* Adjust table layout */
    .table {
        font-size: 14px; /* Reduce font size for better fit */
    }

    .table th, .table td {
        padding: 8px;
    }

    /* Ensure buttons are full width */
    .btn1 {
        width: 100%;
        font-size: 16px;
        padding: 10px;
    }

    /* Modal image responsiveness */
    .modal-body img {
        max-width: 100%;
        height: auto;
    }

    .card-body {
    margin-top: -65px;
}

.container{
 margin-bottom: 60px;
 margin-left:0px;
 font-size: 13px;
}

}   

/* .header {
    background: linear-gradient(to right, #5a6c8e, #b180c7);
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
    border-radius: 8px;
   
} */

/* Default: Desktop View */
.header {
    font-size: 24px; /* Default larger font */
    /* background: linear-gradient(to right, #5a6c8e, #b180c7); */
    /* color: white; */
    margin-bottom: 15px;
  
}

/* For Tablets & Smaller Screens */
@media (max-width: 768px) {  
    .header {
        font-size: 20px;
    }
}

/* For Mobile Screens: Remove the 'header' class styles */
@media (max-width: 480px) {  
    .header {
        font-size: 18px;
    }
}






</style>

<!-- Product Details Card -->
<div class="card">
    <div class="card-body">
    <h3 class="text-center header"><b> Product Details </b></h3>

        <!-- Product Information -->
        <div class="row product-row">
    <div class="col-md-4">
        <p><strong>Product Name:</strong> {{ $product->name }}</p>
        <p><strong>Brand:</strong> {{ $product->brand?? 'N/A' }}</p>
        <p><strong>UOM:</strong> {{ $uom }}</p>

    </div>

 <div class="col-md-4">
 <p><strong>Sales Price:</strong> 
    {{ preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($product->purchase_price, 0, -3)) . 
    (strlen($product->purchase_price) > 3 ? ',' : '') . substr($product->purchase_price, -3) }}</p>  
    <p><strong>Expiry Date:</strong> {{ $product->expiration_date ? \Carbon\Carbon::parse($product->expiration_date)->format('d-m-Y') : 'N/A' }}</p>

    </div>
    <div class="col-md-4">
        <div class="product-image-container">
            @if($product->product_image)
                <img src="{{ asset('storage/app/public/' . $product->product_image) }}" 
                     alt="Product Image" 
                     class="img-fluid product-image">
            @else
                <p><strong>Product Image:</strong> No image available</p>
            @endif
        </div>
    </div>
</div>
 <!-- Specifications Table -->

        <!-- Other Product Details -->
        <h5 class="mt-4">Other  Information</h5>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>GST</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Child Category</th>
                    <!--<th><strong>Status</strong></th>-->
                    <th>Specification</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>{{ number_format($product->tax) }}%</td>

                    <td>{{ $product->category->Category_name ?? 'N/A' }}</td>
                    <td>{{ $product->subcategory->name ?? 'N/A' }}</td>
                    <td>{{ $product->childcategory->name ?? 'N/A' }}</td>
                    <!-- <td>{{ ucfirst($product->status) }}</td> -->
                    <td>
    <!-- Check if specification_name is not null or empty before displaying -->
   <!-- Check if specification_name is not null or empty before displaying -->
    @if($product->specification_name)
        @php
            $specifications_name = json_decode($product->specification_name);
            $specifications_value = json_decode($product->specification_value);
        @endphp
    
    <!-- Ensure that both decoded values are arrays -->
    @if(is_array($specifications_name) && is_array($specifications_value))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th> Name</th>
                    <th> Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specifications_name as $index => $spec_name)
                    <tr>
                        <td>{{ $spec_name ?? 'N/A' }}</td>
                        <td>{{ $specifications_value[$index] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Invalid specifications data.</p>
    @endif
@else
    <p>No specifications available.</p>
@endif
</td>

                </tr>
            </tbody>
        </table>
        </div>

        <div class="d-flex justify-content-center">
    <a href="{{ route('vendor-product') }}" class="btn text-light mt-3 btn1">Back to Products List</a>
</div>



<!-- Image Modal -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Product Image" class="img-fluid" style="max-width: 500px;">
            </div>
        </div>
    </div>
</div>

<!-- Script to handle Image Modal -->
<script>
    $(document).ready(function() {
        // Open modal when image is clicked
        $('.product-image').on('click', function() {
            const imageUrl = $(this).attr('src');
            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').modal('show');
        });

        // Close modal
        $('.close').on('click', function() {
            $('#imageModal').modal('hide');
        });
    });
</script>

@endsection
