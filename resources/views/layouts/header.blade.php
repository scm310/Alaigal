<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sakthi Body Works</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
<link rel="icon" type="image/x-icon" href="/admin_assets/assets/img/car.svg" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    
    <style>
        .image-container {
          overflow-x: auto;
          white-space: nowrap;
          padding: 20px 0;
          margin: 0 auto;
        }
    
        .image-container img {
          width: 350px;
          height: auto;
          margin-right: 10px;
          cursor: pointer;
          transition: transform 0.3s ease-in-out;
        }
    
        .image-container img:hover {
          transform: scale(1.1);
          
          
        }
        .portal-link:hover::after {
        content: "";
        display: block;
        position: absolute;
        top: 100%;
        left: 90%;
        transform: translateX(-50%);
        font-size: 14px;
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        z-index: 999;
    }
    .navbar-toggler-icon {
  
    width: 0.5em !important;
    
}
       
      </style>

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

<!-- Topbar Start -->
<div class="container-fluid bg-dark text-light p-0" style="position: sticky; top: 0; z-index: 1020;">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-10 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                <small>No.46, Poonamallee bypass road, Poonamallee Chennai 56</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center">
                <small class="far fa-clock text-primary me-2"></small>
                <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
            </div>
        </div>
        <div class="col-lg-2 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-phone-alt text-primary me-2"></small>
                <small>9884055853</small>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light" style="position: sticky; top: 10px; z-index: 1010;">
    <a href="{{route('user.index')}}" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
        <h2 class="m-0"><i class="fa fa-car text-primary me-2"></i>Sakthi Body Works</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('user.index') }}" class="nav-item nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">Home</a>
            <a href="{{ route('user.about') }}" class="nav-item nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}">About</a>
            <a href="{{ route('user.gallery') }}" class="nav-item nav-link {{ request()->routeIs('user.gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('user.contact') }}" class="nav-item nav-link {{ request()->routeIs('user.contact') ? 'active' : '' }}">Contact Us</a>
        </div>
       <a href="{{ route('user.login') }}" class="btn btn-primary py-4 px-lg-5 d-lg-block portal-link" style="margin-right: 10px; border-radius: 10px;">
    Login <i class="fa fa-arrow-right ms-3"></i>
</a>
    </div>
</nav>
<!-- Navbar End -->

    @yield('content1')
    @include('layouts.footer')

            <!-- JavaScript Libraries -->
        
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets/lib/wow/wow.min.js')}}"></script>
<script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html> 