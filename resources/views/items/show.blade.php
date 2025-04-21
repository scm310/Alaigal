@extends('admin_layouts.app')

@section('content')

<style>

.modal-backdrop {
    background-color: transparent !important;
}

    /* Apply consistent table styling */
    #productTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }


    #productTable th {
        border: 2px solid #ddd;
        padding: 8px;
        background-color: #A87676;
        text-align: center;
        color: white;
    }

    #productTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Image hover effect */
    .product-image:hover {
        cursor: pointer;
        transition: transform 0.3s ease;
        transform: scale(1.2);
    }

    /* Hide sorting icons */
    table#productTable thead th {
        background-image: none !important;
        cursor: default !important;
    }
</style>

<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>Product Details</b> <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a></h4>


            <div class="container">

                <!-- Product Details Card -->
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $item->item_name }}</h3>
                    </div>
                    <div class="card-body">
                 

<!-- @if ($item->status == 'admin')
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <p><strong>Product Name:</strong> {{ $item->item_name }}</p>
                <p><strong>Product ID:</strong> {{ $item->product_id }}</p>
                <p><strong>Brand:</strong> {{ $item->brand ?? 'N/A' }}</p>
                <p><strong>Uom:</strong> {{ $item->uom_name ?? 'N/A' }}</p>
            </div>

            <div class="col-md-4">
            <p><strong>Sales Price :</strong> 
    {{ $item->sales_price == floor($item->sales_price) 
        ? preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($item->sales_price, 0, -3)) . (strlen($item->sales_price) > 3 ? ',' : '') . substr($item->sales_price, -3) 
        : preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr(number_format($item->sales_price, 2), 0, -6)) . (strlen(number_format($item->sales_price, 2)) > 6 ? ',' : '') . substr(number_format($item->sales_price, 2), -6) 
    }}
</p>                <p><strong>GST:</strong> {{ $item->tax }}%</p>
                <p><strong>CGST:</strong> {{ $item->tax / 2 }}%</p>
                <p><strong>SGST:</strong> {{ $item->tax / 2 }}%</p>
            </div>

            <div class="col-md-4">
                @if ($item->product_image)
                    <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid product-image" style="max-height: 350px;" data-toggle="modal" data-target="#imageModal" data-image="{{ asset('storage/app/public/' . $item->product_image) }}">
                @else
                    <img src="{{ asset('default-image.jpg') }}" alt="Default Product Image" class="img-fluid" style="max-height: 150px;">
                @endif
            </div>
        </div>
        <div class="row">
          
        </div>
    </div>

@elseif ($item->status == 'vendor') -->
   
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <p><strong>Product Name:</strong> {{ $item->item_name }}</p>
                    <p><strong>Product ID:</strong> {{ $item->product_id }}</p>
                    <p><strong>Brand:</strong> {{ $item->brand ?? 'N/A'}}</p>
                    <p><strong>Uom:</strong> {{ $item->uom_name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-3">
                    <p><strong>Vendor Name:</strong> {{ $item->vendor_name }}</p>
                    <p><strong>Email:</strong> {{ $item->email }}</p>
                    <p><strong>Phone:</strong> {{ $item->phone }}</p>
                </div>

                <div class="col-md-3">
                <p><strong>Sale Price:</strong> 
    {{ $item->sales_price == floor($item->sales_price) 
        ? preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($item->sales_price, 0, -3)) . (strlen($item->sales_price) > 3 ? ',' : '') . substr($item->sales_price, -3) 
        : preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr(number_format($item->sales_price, 2), 0, -6)) . (strlen(number_format($item->sales_price, 2)) > 6 ? ',' : '') . substr(number_format($item->sales_price, 2), -6) 
    }}
</p>
<!-- 
<p><strong>Purchase Price:</strong> 
    {{ $item->purchase_price == floor($item->purchase_price) 
        ? preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($item->purchase_price, 0, -3)) . (strlen($item->purchase_price) > 3 ? ',' : '') . substr($item->purchase_price, -3) 
        : preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr(number_format($item->purchase_price, 2), 0, -6)) . (strlen(number_format($item->purchase_price, 2)) > 6 ? ',' : '') . substr(number_format($item->purchase_price, 2), -6) 
    }}
</p> -->
<p><strong>GST:</strong> {{ number_format($item->tax, 0) }}%</p>

                    <p><strong>CGST:</strong> {{ $item->tax / 2 }}%</p>
                    <p><strong>SGST:</strong> {{ $item->tax / 2 }}%</p>
                </div>

                <div class="col-md-3">
                    @if ($item->product_image)
                        <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid product-image" style="max-height: 150px;" data-toggle="modal" data-target="#imageModal" data-image="{{ asset('storage/app/public/' . $item->product_image) }}">
                    @else
                        <img src="{{ asset('default-image.jpg') }}" alt="Default Product Image" class="img-fluid" style="max-height: 150px;">
                    @endif
                </div>
            </div>
            <div class="row">
                <!-- Additional rows can go here -->
            </div>
        </div>
    </div>
<!-- @endif -->

                    </div>
                </div>

                <!-- Specifications Table -->
                <div class="card mt-4">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <table id="productTable" class="table">
                            <thead>
                                <tr>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">S.No</th>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">Main Category</th>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">Sub Category</th>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">Child Category</th>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">Specification Name</th>
                                    <th style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">Specification Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $previousItemId = null;
                                @endphp

                                @foreach ($specificationNames as $index => $specName)
                                @if ($previousItemId !== $item->product_id) <!-- Check if it's the first specification for the product -->
                                <tr>
                                    <td rowspan="{{ count($specificationNames) }}" style="vertical-align: middle;">1</td>
                                    <td rowspan="{{ count($specificationNames) }}" style="vertical-align: middle;">{{ $item->category_name  ?? 'N/A'}}</td>
                                    <td rowspan="{{ count($specificationNames) }}" style="vertical-align: middle;">{{ $item->subcategory_name  ?? 'N/A'}}</td>
                                    <td rowspan="{{ count($specificationNames) }}" style="vertical-align: middle;">{{ $item->child_category_name ?? 'N/A' }}</td>
                                    <td>{{ $specName }}</td>
                                    <td>{{ $specificationValues[$index] ?? 'N/A' }}</td>
                                </tr>
                                @php
                                $previousItemId = $item->product_id;
                                @endphp
                                @else
                                <!-- For other specifications, leave the first cells blank -->
                                <tr>
                                    <td>{{ $specName }}</td>
                                    <td>{{ $specificationValues[$index] ?? 'N/A' }}</td>
                                </tr>
                                @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
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
                            <img id="modalImage" src="" alt="Product Image" class="img-fluid" style="max-width: 700px;">
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<script>
    // Modal image preview script
    $('.product-image').on('click', function() {
        const imageSrc = $(this).data('image');
        $('#modalImage').attr('src', imageSrc);
    });
</script>
@endsection