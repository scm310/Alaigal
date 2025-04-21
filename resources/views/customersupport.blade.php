@extends('memberlayout.navbar')

@section('content')

<style>

.container-wrapper {
        width: 95%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    /* Header */
    .header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    /* Container styling */
    .content-container {
        width: 90%; /* Default width */
        max-width: 1200px; /* Maximum width */
        margin: 0 auto; /* Center the container */
        padding: 0 20px; /* Add some padding */
    }

    /* Image styling */
    .top-centered-image {
        width: 100%; /* Ensure the image is responsive */
        max-height: 100vh; /* Ensure it fits within the viewport */
        border-radius: 15px; /* Optional rounded corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5); /* Optional shadow effect */
        margin-top: 50px; /* Image margin */
    }

    /* Heading Styling */
    .page-heading {
        text-align: center; /* Center align the heading */
        font-size: 30px; /* Adjust size */
        font-weight: bold;
        color: #eee; /* Light color for contrast */
        margin-top: 60px; /* Adjust margin-top to lightly push it down */
        margin-bottom: 20px; /* Space below the heading */
        margin-right:800px;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .content-container {
            width: 95%; /* Make container a little smaller */
            padding: 0 15px; /* Adjust padding */
        }

        .top-centered-image {
            max-height: 60vh; /* Adjust max-height for smaller screens */
            margin-top: 20px; /* Adjust margin-top */
        }

        .page-heading {
            font-size: 24px; /* Make the heading slightly smaller */
            margin-top: 30px; /* Adjust the margin-top for smaller screens */
        }
    }

    /* Further adjustments for very small screens (e.g., phones) */
    @media (max-width: 480px) {
        .content-container {
            width: 100%; /* Full width for very small screens */
            padding: 0 10px; /* Adjust padding for small screens */
        }

        .top-centered-image {
            max-height: 100vh; /* Adjust max-height for very small screens */
            margin-top: 40px; /* Adjust top margin for small screens */
        }

        .page-heading {
            font-size: 20px; /* Smaller heading for very small screens */
            margin-top: 128px; /* Adjust margin-top for small screens */
            margin-right: 154px;
        }
    }
</style>
<div class="container-wrapper mt-5">
    <div class="header">Customer Support</div>

    <div class="content-container">
        <div class="top-centered-image-container">
            @foreach ($banners as $banner)
                @if (!empty($banner->image))
                    <!-- Displaying image -->
                    <img src="{{ asset('storage/app/public/customer_banner/' . $banner->image) }}" alt="Centered Image" class="top-centered-image">
                @else
                    <p>No image found for this record.</p>
                @endif
            @endforeach
        </div>
    </div>
</div>

@endsection
