@extends('admin_layouts.app')
<style>
    .btn-default {
        background-color: #853ede !important;
        color: white !important;
        border-color: #853ede !important;
    }

    .btn-secondary {
        background-color: #853ede !important;
        color: white !important;
        border-color: #853ede !important;
    }

    .btn-secondary:hover {
        background-color: gray !important;
        color: white !important;
    }
    </style>
@section('content')
<div class="container-fluid py-5" style="background-color:rgb(250, 251, 253); min-height: 100vh;"> <!-- Background applied -->
    <div class="container d-flex justify-content-center"> <!-- Center content -->
        <div class="card shadow-lg rounded" style="width: 40%; background: white;"> <!-- Styled card -->
            <div class="card-body">
                <h2 class="text-center mb-4 ">Edit Highlight</h2>

                <form action="{{ route('highlight.update', $highlight->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $highlight->name }}" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-default px-4">Update</button>
                        <button type="button" class="btn btn-secondary px-4" onclick="window.history.back();">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
