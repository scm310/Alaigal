@extends('admin_layouts.app')

@section('content')
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

    /* Centering card inside container */
    .card {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
</style>
<div class="container-fluid py-5" style="background-color:rgb(250, 251, 253); min-height: 100vh;"> <!-- Background applied -->
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">Add Highlight</h2>

            <form action="{{ route('highlight.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>

                </div>

           

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-default">Add</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
