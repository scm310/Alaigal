
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add your custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Super Admin Navbar -->
    @include('superadmin.navbar')

    <div class="container mt-4">
        @yield('content') <!-- This is where page-specific content will be injected -->
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>