@extends('vendor_layouts.app')

@section('content1')
<div class="container mt-5">
    <h2>Vendor Quotes</h2>
    <table id="example" class="table table-striped table-bordered mt-4 pt-4">
        <thead class="bg-primary">
            <tr>
                <th scope="col" style="color:white;text-align:center;">S.No</th>
                <th scope="col" style="color:white;text-align:center;">Date & Time</th>
                <th scope="col" style="color:white;text-align:center;">Product Name</th>
                <th scope="col" style="color:white;text-align:center;">Quantity</th>
                <th scope="col" style="color:white;text-align:center;">Location</th>
                <th scope="col" style="color:white;text-align:center;">Username</th>
            </tr>
        </thead>
        <tbody>
        @if($enquiries->isEmpty())
            <tr>
                <td colspan="6" class="text-center">No Data Found</td>
            </tr>
        @else
            @foreach($enquiries as $key => $enquiry)
            <tr>
                <td>{{ $key + 1 }}</td> <!-- S.No -->
                <td>{{ $enquiry->created_at }}</td>
                <td>
    <a href="{{ route('vendor-product', ['id' => $enquiry->id]) }}">
        {{ $enquiry->product_name ?? 'N/A' }}
    </a>
</td>

                <td>{{ $enquiry->quantity ?? 'N/A' }}</td>
                <td>{{ $enquiry->location }}</td>
                <td>{{ $enquiry->user_name }}</td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>




@endsection
