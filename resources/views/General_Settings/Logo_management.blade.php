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
        .footer {
    background-color: #f8f9fa;
    padding: 1rem 0;
    margin-top:265px;
}
.content-wrapper{
        background-color: white;
    }
    html, body {
    overflow-x: hidden;
}
.custom-alert {
    width: 30%; /* Reduce the width */
    position: fixed;
    top: 70px; /* Adjust the top position */
    left: 57%;
    transform: translateX(-50%); /* Center horizontally */
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    z-index: 9999; /* Ensure it's above other content */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}


</style>


    {{-- Success Message --}}
        @if(session('success'))
        <div class="alert alert-success custom-alert">
            {{ session('success') }}
        </div>
    @endif


    {{-- Row for Cards --}}
    <div class="row d-flex justify-content-center" style="margin-top:70px;">

        {{-- Header Section Card --}}
        {{-- <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Company Name</h4>
                </div>
                <div class="card-body text-center">
                    @foreach($logos as $logo)
                        <div class="mb-3">
                            <h5 class="mb-4">{{ $logo->heading }}</h5>
                           
                            <form action="{{ route('logos.updateHeading', $logo->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="heading" class="form-label" style="transform: translateY(15px);">Update Name</label>
                                    <input type="text" name="heading" id="heading" class="form-control" required style="transform: translateY(15px);" placeholder="company name">
                                </div>
                                <button type="submit" class="btn btn-primary" style="transform: translateY(15px);">Update Name</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Company Logo</h4>
                </div>
                <div class="card-body text-center">
                    @foreach($logos as $logo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/app/public/' . $logo->logo_path) }}" alt="Logo" class="img-thumbnail" style="max-width:45px; height:45px; margin-left:70px;">
                        </div>
                    @endforeach

                    <form action="{{ route('logos.storeLogo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="logo" class="form-label">Choose Company Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Logo</button>
                    </form>
                </div>
            </div>
        </div> --}}
<!-- 
        {{-- Admin Name Section --}}
        <div class="col-md-3 mb-4">
            <div class="card" style="height:290px;">
                <div class="card-header text-center">
                    <h4>Admin Name</h4>
                </div>
                <div class="card-body text-center">
                    @foreach($logos as $logo)
                        <div class="mb-3">
                            <h5 style="font-size:19px; margin-top:10px;"> {{ $logo->admin_name }}</h5>
                        </div>
                    @endforeach

                    {{-- Admin Name Form --}}
                    <form action="{{ route('logos.storeAdminName') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_name" class="form-label" style="transform: translateY(15px);">Enter Admin Name</label>
                            <input type="text" class="form-control" id="admin_name" name="admin_name" required placeholder="Admin name" style="transform: translateY(15px);">
                        </div>
                        <button type="submit" class="btn btn-primary" style="transform: translateY(15px);">Save Admin Name</button>
                    </form>
                </div>
            </div>
        </div> -->

        {{-- Admin Logo Section --}}
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Admin Logo</h4>
                </div>
                <div class="card-body text-center">
                    @foreach($logos as $logo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/app/public/' . $logo->admin_logo) }}" alt="Admin Logo" class="img-thumbnail" style="width:40px;height:43px;margin-left:70px;">
                        </div>
                    @endforeach

                    {{-- Admin Logo Form --}}
                    <form action="{{ route('logos.storeAdminLogo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_logo" class="form-label">Upload Admin Logo</label>
                            <input type="file" class="form-control" id="admin_logo" name="admin_logo" required>
                        </div>
                        <button type="submit" class="btn btn-default">Save Admin Logo</button>
                    </form>
                </div>
            </div>
        </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            $(".custom-alert").fadeOut(1000); // Fade out in 1 second after 3 seconds
        }, 3000);
    });
</script>


@endsection
