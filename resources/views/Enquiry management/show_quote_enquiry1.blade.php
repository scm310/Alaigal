@extends('admin_layouts.app')

@section('content')
<div class="container">
    <h2>Product Details</h2>
    <table class="table table-bordered">
        @if ($productDetails->isNotEmpty()) <!-- Check if collection is not empty -->
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>GST</th>
                    <th>CGST</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productDetails as $key => $product) <!-- Loop through collection -->
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>₹{{ number_format($product->price, 2) }}</td> <!-- Show price -->
                    <td>₹{{ number_format($product->sgst, 2) }}</td> <!-- Show GST -->
                    <td>₹{{ number_format($product->cgst, 2) }}</td> <!-- Show CGST -->
                    <td>₹{{ number_format($product->total, 2) }}</td> <!-- Show calculated total -->
                </tr>
                @endforeach
            </tbody>
        @else
        <tr>
            <td colspan="7" class="text-center">Product details not found.</td>
        </tr>
        @endif
    </table>
    <a href="{{ route('quote.enquiries') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
