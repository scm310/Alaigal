@extends('admin_layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Banner</h1>

    <!-- Success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Error messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card for the form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('listingbanner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <label for="bannerImage">Select Banner Image</label>
                        <input type="file" class="form-control" id="bannerImage" name="image" accept="image/*">
                        <img src="{{ asset('storage/app/public/' . $banner->image) }}" class="img-fluid mt-2" alt="Banner Image" style="width: 100px; height: 30px; object-fit: cover;">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary mt-4">Update Banner</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
