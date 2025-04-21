@extends('admin_layouts.app')

@section('content')
<style>
    .btn-default {
        background-color: #853ede !important;
        color: white !important;
        border-color: #853ede !important;
    }

   
    </style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Vendor Details</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Vendor</th>
                    <td>{{ $vendor->name }}</td>
                </tr>
                <tr>
                    <th>Company Name</th>
                    <td>{{ $vendor->company_name }}</td>
                </tr>
                <tr>
                    <th>Company Website</th>
                    <td>{{ $vendor->company_website }}</td>
                </tr>
              
                <tr>
                    <th>Email</th>
                    <td>{{ $vendor->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $vendor->phone }}</td>
                </tr>
                <tr>
                    <th>GST Number</th>
                    <td>{{ $vendor->gst_number }}</td>
                </tr>
                
               
               
            </table>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('approval.vendor') }}" class="btn btn-default">Back to List</a>
        </div>
    </div>
</div>
@endsection
