@extends('admin_layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Uploaded Banners</h2>

    <div class="row">
        @foreach ($banners as $banner)
        <div class="col-md-4 mb-3">
            <img src="{{ asset('storage/' . $banner->image_path) }}" class="img-fluid" alt="Banner">
        </div>
        @endforeach
    </div>
</div>
@endsection
