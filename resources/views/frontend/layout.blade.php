<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
    <meta charset="utf-8">
    <title>TIEPMD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('themes/css/bootstrappage.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/css/flexslider.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/css/main.css') }}" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('themes/js/jquery.flexslider-min.js') }}"></script>
    
<link rel="icon" href="{{ asset('storage/app/public/' . $gl->favicon) }}" type="image/x-icon">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>

<body>


    @yield('content')

   
</body>

</html>