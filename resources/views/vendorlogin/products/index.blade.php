@extends('vendor_layouts.app')

@section('content1')
    <div class="container">
        <h2>Vendor Products</h2>

        <!-- Button to create a new product -->
        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary mb-3">Create New Product</a>

        <!-- Table to display products -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Brand/Group</th>
                    <th>Unit</th>
                    <th>Sales Price</th>
                    <th>Purchase Price</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->brand_group }}</td>
                        <td>{{ $item->unit->name }}</td>
                        <td>{{ $item->sales_price }}</td>
                        <td>{{ $item->purchase_price }}</td>
                        <td>{{ $item->expiry_date }}</td>
                        <td>
                            <!-- Actions (Edit, Delete) -->
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
