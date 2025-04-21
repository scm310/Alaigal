@extends('admin_layouts.app')

@section('content')

<style>
    .card {
        max-width: 640px;
        width: 80%;
        min-height: 377px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 15px;
        margin-left: 220px;
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .form-group {
        flex-grow: 1;
    }

    /* Centered Upload Button at Bottom */
    .btn-upload-container {
        display: flex;
        justify-content: center;
        margin-top: auto;
        padding-top: 20px;
    }

    .btn-upload {
        background-color: #8e4b46;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        width: 40%;
        text-align: center;
        font-weight: bold;
    }

    .btn-upload:hover {
        background-color: rgb(125, 52, 189);
        color:white;
    }

    .banner-hover {
        transition: transform 0.3s ease-in-out;
        margin-left: 105px;
    height: 50px;
    width: 271px;
    }
    .banner-hover:hover {
        transform: scale(2); /* Increases the size by 20% on hover */
    }
</style>

<div class="container mt-5">
    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#8e4b46",
                confirmButtonText: "OK",
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
    @endif

    <div class="card shadow-lg rounded-lg p-4">
        <div class="card-body">
            <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <h4 class="text-center mb-4">Edit Banner Image
                    <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </h4>

                <div class="form-group mb-3">
                    <label for="bannerImage" class="font-weight-bold text-dark">Current Banner Image</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/app/public/' . $banner->image_path) }}"
                             class="img-fluid rounded shadow banner-hover"
                             width="200"
                             alt="Current Banner">
                    </div>
                </div>

                <div class="form-group">
                    <label for="bannerImage" class="font-weight-bold text-dark">Select New Banner Image (optional)</label>
                    <input type="file" class="form-control file-input" id="bannerImage" name="image" accept="image/*">
                    <small class="text-muted">Note: Banner Size - 1250x250.</small>
                </div>

                <!-- Centered Button at Bottom -->
                <div class="btn-upload-container">
                    <button type="submit" class="btn btn-upload">Upload Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
