@extends('admin_layouts.app')

@section('content')
<style>
    /* Add hover effect for images */
    .zoom-in img {
        transition: transform 0.3s ease; /* Smooth zoom effect */
    }

    .zoom-in img:hover {
        transform: scale(2.5);
        border-radius:5px;
        /* Zoom in the image */
    }
</style>

<div class="container">
    <h1 class="mb-4">Banner Image Upload</h1>

    <!-- Success message after uploading -->
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

<div class="card">
    <div class="card-body">
        <form action="{{ route('listingbanner.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label for="bannerImage">Select Banner Image</label>
                    <input type="file" class="form-control custom-width" id="bannerImage" name="image[]" accept="image/*" required multiple style="width: 100%;">
                      <p><b>Note:</b> Banner Size - 1250px x 250px.</p>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4">Upload Banner</button>
                </div>
            </div>
        </form>
    </div>
</div>

    

   

    <!-- Displaying Uploaded Banner Images -->
    <div class="mt-4">
        <h3>Uploaded Banners</h3>
        <table class="table table-bordered zoom-in" style="width:700px; margin-left:100px; border:1px solid black;">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($listingbanner as $banner)
                <tr>
                    <!-- Display the image with correct path -->
                    <td style="width:80px;">
                        <img src="{{ asset('storage/app/public/' . $banner->image) }}" class="img-fluid" alt="Banner" style="width: 100px; height:30px; object-fit: cover;">
                    </td>

                    <td style="width:50px;">
                        <!-- Delete Button -->
                        <form action="{{ route('listingbanner.destroy', $banner->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this banner?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </button>

                        </form>
                        <!-- Edit Button -->
                        <a href="{{ route('listingpage.edit', $banner->id) }}" class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146 0l3.707 3.707a1 1 0 0 1 0 1.414l-9.03 9.03a1 1 0 0 1-.524.276l-4.42 1.478a1 1 0 0 1-1.276-1.276l1.478-4.42a1 1 0 0 1 .276-.524l9.03-9.03a1 1 0 0 1 1.414 0L12.146 0zM11.207 4.707l-7.792 7.792-1.063.354.354-1.062 7.792-7.792a1 1 0 0 1 1.414 1.414L11.207 4.707z" />
                            </svg>
                        </a>



                    </td>

                    <!-- Edit Button -->

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection