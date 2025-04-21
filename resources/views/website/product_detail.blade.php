@extends('frontend.layout')
@section('content')

@include('frontend.parital.topheader')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<div id="wrapper" class="container">
    @include('frontend.parital.categorylisting')




    <style>
        /* IndiaMART-style Phone Input */
        .phone-group {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 308px;
            border-radius:8px;
            padding:6px;
            margin-left:-4px;
            height: 30px;
        }

        .iti {
            width: auto;
        }

        .phone-group input {
            flex: 1;
            border: none;
            font-size: 16px;
            outline: none;
            padding-left: 10px;
            width: 100%;
        }


    </style>
    <style>
        .product-image {
            width:170px;
            border-radius: 8px;
            height: 200px;
            margin-top: 70px;
        }

        .thumbnail {
            max-width: 50px;
            border: 2px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 8px;
            height: 50px;
        }

        .thumbnail:hover {
            border-color: #007bff;
        }

        .price {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }

        .tab-content {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .related-products .card {
            border: none;
            transition: transform 0.3s;
        }

        .related-products .card:hover {
            transform: scale(1.05);
        }


        .rating {
            color: #ff9800;
        }

        .product-details ul {
            list-style-type: none;
            padding: 0;
            margin-top:-12px;
        }

        .product-details ul li {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .product-description {
            font-size: 15px;
            color: #555;
            line-height: 1.6;
        }


        .thumbnail {
            width: 80px;
            /* Adjust the size of thumbnails */
            height: auto;
            border: 1px solid #ddd;
            /* Adds a border */
            border-radius: 5px;
            /* Optional: for rounded corners */
            cursor: pointer;
        }

        .thumbnail-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center the thumbnails horizontally */
        }



    </style>
    <style>
        /* Main Image Styling */
        .main-image img {
            max-width:100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: -50px;
        }

        /* Gallery Thumbnail Styling */
        .gallery-thumbnail img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid black;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .gallery-thumbnail img:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }



        .add-to-cart-btn {
            background-color: #9055fd;
            color: white;
            border: none;
            padding:5px 0px;
            border-radius: 5px;
            cursor: pointer;
            width:125px;
            height:32px;
        }


        /* Remove unwanted padding or margins */
        #additionalInfo {
            margin-top: 0;
            padding-top: 0;
        }

        /* Adjust the space between the specification section and the next section */
        .specification-section {
            margin-bottom: 10px;
            /* Adjust as needed */
        }


        .thumbnail-img {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .thumbnail-img:hover {
            transform: scale(1.1);
            /* Slight zoom effect */
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .gallery-thumbnail img {
                width: 60px;
                height: 60px;
            }

            .price {
                font-size: 1.2rem;
            }
        }
    </style>
    <style>

        /* Custom tab navigation */
        .custom-nav .nav-link {
            font-size: 1.1rem;
            padding: 5px 20px;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.3s;
            border: 2px solid transparent;
        }

         .custom-nav .nav-link:hover {

            background-color:none !important;

        }

        .custom-nav .nav-link.active {
            background-image: linear-gradient(90deg,rgb(186, 138, 121),rgb(188, 151, 144));
            color: white !important;
            border: 1.5px solid;
            border-color: rgb(150, 148, 148);
        }

        /* Styling content */
        .description-content {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .specification-content {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width:650px;
            margin-left: 280px;
        }
    </style>
    <style>
        /* Reduce table font size and padding */
        .table {
            font-size: 0.9rem;
            /* Smaller font size */
            margin-bottom: 1rem;
            width:610px;
            /* Reduced bottom margin */
        }

        /* Adjust padding inside table cells */
        .table th,
        .table td {
            padding: 8px 12px;
            width:500px;
            /* Reduced padding for a more compact table */
        }


        .table td {
            width: 600px;
        }
        /* Adjust the row height for compactness */
        .table tbody tr {
            height: 35px;
            /* Smaller row height */
        }

        /* Styling for odd rows */
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
            /* Subtle background for odd rows */
        }

        /* Hover effect for rows */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            /* Hover color */
        }

        /* Table headers with bold and lighter background */
        .table th {
            background-color: #f0f0f0;
            color: #333;
            font-weight: bold;
        }

        /* Table cells with softer background */
        .table td {
            background-color: #fff;
            color: #666;

        }
    </style>
    <style>
        .title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .price {
            font-size: 16px;
            color: #e67e22;
            margin-top: 5px;
        }



        .product-image {
            width: 200px;
            /* Ensure image size is exactly 100x100px */
            height: 200px;
            object-fit:fill;
        }


    .main-image-container {
    position: relative;
    display: inline-block;
    width: 100%;
    max-width:300px;
    cursor:pointer;
}

#mainProductImage {
    width: 100%;
    display: block;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.zoom-result {
    position: absolute;
    top:140px;
    left:43%; /* Show zoomed image on the right */
    width:700px; /* Adjust size */
    height:400px;
    border: 1px solid #ddd;
    background-repeat: no-repeat;
    display: none;
    overflow: hidden;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
    border-radius:8px;
    z-index:1000000;
}

    </style>

    <style>
        /* Styling for the Related Products Section */


        .product-image {
            height: 150px;
            object-fit:fill;
            margin-bottom: 10px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black !important;
            /* For background arrows */
        }

        .carousel-control-prev svg,
        .carousel-control-next svg {
            fill: black;
            /* For SVG arrows */
        }

        /* Form Container */
        .form-container {
            background: lawngreen;
            border-radius: 12px;
            padding: 30px 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        /* Form Header */
        h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Fields */
        .form1 {
            display: flex;
            flex-direction: column;
            gap:18px;
            background: linear-gradient(109.6deg, rgb(204, 228, 247) 11.2%, rgb(237, 246, 250) 100.2%);
            border-radius: 12px;
            padding:20px 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 330px;
            text-align: center;
            height:350px;
            margin-top:-10px;
        }



        .form-input {
            flex: 1;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
            transition: 0.3s ease;
        }

        .form-input:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
        }

        /* Textarea (Message Box) */
        .message-box {
            height:150px !important;
            width:290px;
            margin-left:0px;
            padding:20px 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
            transition: 0.3sease;
        }

        /* Submit Button */
        .submit-btn {
            text-transform: capitalize !important;
            padding: 9px 9px;
            background-color:#A87676;;
            color: white;
            font-size: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
            text-transform: uppercase;
            font-weight: bold;
            width: 100px;
            margin-left: 95px;
        }

        .submit-btn:hover{
            background-color: #9055fd;
        }



        .video-thumbnail-wrapper {
    position: relative;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.video-thumbnail-wrapper:hover {
    transform: scale(1);
}

.video-play-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size:10px;
    color: white;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 50%;
    padding:8px 10px;
    pointer-events: none;
}

.specific{
    margin-left:70px;
    transform: translateY(-20px);
}

.quote{
 margin-left:5px;
 transform: translateY(-10px);
}

.btn{
    background-color:#A87676;;
}

.btn:hover{
    background-color: #9055fd;
}

button{
    background-color:#A87676;;
}
/* button:hover{
    background-color: #9055fd;
} */

.nav-pills .nav-link.active,
.nav-pills .show>.nav-link {
    background-color: transparent !important; /* Removes the background color */
}


.specification{
    margin-left: 160px;
}

@media (max-width: 768px) {


/* Form Fields */
.form1 {
    display: flex;
    flex-direction: column;
    gap:18px;
    background: linear-gradient(109.6deg, rgb(204, 228, 247) 11.2%, rgb(237, 246, 250) 100.2%);
    border-radius: 12px;
    padding:20px 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    width: 330px;
    text-align: center;
    height:400px;
    margin-left:0px;
    margin-top:15px;
}


.specification-content {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 360px;
    margin-left:-5px;
    word-break:break-word;
}


#wrapper{
        overflow-x: hidden !important;
    }

.specification{
margin-left:60px;
}

.carousel-control-next, .carousel-control-prev {

    display:none;
}

.zoom-result{
    display:none;
}


.product-image {
height:110px;
width: 140px;
object-fit: fill;
}

.description-content{
    word-break: break-word;
}

}

/* Mobile View: Display Thumbnails in Horizontal Scroll */
@media (max-width: 767px) {
    .mobile-thumbnails {
        flex-direction: row !important;
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
        padding-bottom: 10px;
        justify-content: start;
        gap: 10px;
    }
    .gallery-thumbnail {
        display: inline-block;
        margin-bottom: 0;
        width: 60px; /* Adjust thumbnail size for mobile */
    }
    .gallery-thumbnail img {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }
    .main-image-container img {
        width: 100%;
        max-width: 300px; /* Ensure it doesn't get too big */
    }

    #wrapper{
        overflow-x: hidden !important;
    }

    .mobile-scroll-container {
    display: flex;
    overflow-x: auto;
    white-space: nowrap;
    gap: 10px;
    padding-bottom: 10px;
}

.mobile-product-box {
    flex: 0 0 auto;
    width: 150px;
}

}


/* Style for the input row */
.input-row {
    display: flex;
    gap: 10px; /* Spacing between inputs */
}

/* Make both fields equal width */
.input-row .form-input {
    width: 50%;
}





</style>

<style>
    .message-container {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 400px;
        text-align: center;
        z-index: 9999;
    }

    .alert {
    width: 325px;
    padding: 10px;
    border-radius: 5px;
    font-size:10px;
    font-weight: bold;
    transform: translateX(485px);
    margin-top: 115px;
}

    /* Mobile View */
    @media (max-width: 576px) {
        .message-container {
            width: 95%;
            font-size: 12px;
        }
        .alert {
        width: 325px;
        padding: 10px;
        border-radius: 5px;
        font-size: 10px;
        font-weight: bold;
        transform: translateX(30px);
        margin-top:352px;
    }

    .zoom-result {
            display: none !important;
        }

        .d-md-none {
            margin-top: -50px;
        }
    }
</style>
    <body>

        <div id="wrapper" class="container">
            <div class="container my-5">

                <div class="row">
                    <!-- Left: Gallery Thumbnails -->
                    <!-- Left: Gallery Thumbnails -->

    <!-- Thumbnails (Gallery Images & Videos) -->
    <div class="col-md-1 d-flex flex-column align-items-start mobile-thumbnails">
        @if(!empty($product->gallery_images))
            @foreach(json_decode($product->gallery_images) as $image)
            <div class="gallery-thumbnail mb-2">
                <img
                    src="{{ Storage::url('app/public/' . $image) }}"
                    class="img-fluid thumbnail-img"
                    alt="Gallery Image"
                    data-src="{{ Storage::url('app/public/' . $image) }}"
                    onmouseover="changeMainImage(this)">
            </div>
            @endforeach
        @endif

        @if(!empty($product->gallery_video))
            <div class="gallery-thumbnail mb-2 position-relative video-thumbnail-wrapper"
                 onclick="playVideo('{{ Storage::url('app/public/' . $product->gallery_video) }}')">
                <img
                    src="{{ Storage::url('app/public/' . json_decode($product->gallery_images)[0]) }}"
                    class="img-fluid thumbnail-img"
                    alt="Video Thumbnail">
                <span class="video-play-icon">&#9658;</span>
            </div>
        @endif
    </div>

    <!-- Main Product Image -->
    <div class="col-md-4 text-center">
        <div class="main-image-container">
            <img
                id="mainProductImage"
                src="{{ Storage::url('app/public/' . $product->product_image) }}"
                class="img-fluid"
                alt="Main Product Image">
        </div>
        <div class="zoom-result" id="zoomResult"></div>
    </div>

                    <!-- Right: Product Details -->
                    <div class="col-md-4">
                        <h2 class="mb-3">{{ $product->name }}</h2>
                        <p class="price">
    ₹<span id="formattedPrice">{{ $product->sales_price }}</span>
    &nbsp; <span class="text-dark" style="font-size:11px; font-weight:100;">Inclusive of all taxes</span>
</p>

                        <!-- Product Details -->
                        <div class="product-details mt-4">
                            <ul>
                                <li><strong>Brand:</strong> {{ $product->brand }}</li>
                                <li><strong>Model:</strong> {{ $product->name }}</li>
                                <!-- <li><strong>Color:</strong> {{ $product->colors}}</li> -->

                            </ul>
                        </div>
                        <div class="specification-content1" style="margin-top:-5px; font-weight:400;">
    <h6 class="fw-bold" >Product Specifications</h6>
    @if(!empty($specifications))
        <ul class="specifications-list">
            @foreach($specifications as $name => $value)
                <li class="specification-item {{ $loop->index >= 4 ? 'd-none extra-specs' : '' }}" style="font-size:13px;">
                    <span class="fw-bold">{{ ucfirst($name) }}:</span> {{ ucfirst($value) }}
                </li>
            @endforeach
        </ul>
<!-- Read More Link -->
<a href="#additionalInfo-tab" onclick="navigateToSpecification(event);">Read More</a>

    @else
        <p class="text-center text-muted">No specifications available</p>
    @endif
</div>

                            <!-- <form id="addToCartForm" class="d-flex align-items-center mt-3 quote">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="d-flex align-items-center mb-2">
            <label for="quantity" class="fw-bold me-2">Quantity:</label>
            <input type="number" id="quantity" class="form-control me-2" name="quantity" value="1" min="1" style="height:30px; width:80px;">
        </div>
        <button type="submit" class="btn add-to-cart-btn" style="margin-top:-7px;">Add to Quote</button>
    </form> -->

                        <!-- Display Success Message -->
                        <!-- <div id="successMessage" class="alert alert-success" style="display: none;">Product added to quote!</div> -->
                    </div>

                    <div class="col-md-3">
    <!-- Message Container Inside Form -->
    <div class="message-container">
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
</div>


    <form action="{{ route('enquiry.store') }}" method="POST" class="form1">
        @csrf
        <h6>Schedule a Call</h6>    

        <!-- Name and Phone in one row -->
        <div class="input-row">
            <input type="text" id="name" name="name" placeholder="Name" class="form-input" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" required>

            <input type="tel" id="phone" name="phone" maxlength="10" placeholder="Enter your mobile" class="form-input number" required>
        </div>

        <!-- Email Input -->
        <input type="email" name="email" placeholder="Email" class="form-input" required>

        <!-- Message Box -->
        <textarea name="message" placeholder="Message" class="message-box" cols="5" required oninput="validateMessage(this)"></textarea>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>

<!-- Script to Auto-Close the Message After 3 Seconds -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var message = document.getElementById("success-message");
            if (message) {
                message.style.transition = "opacity 0.5s";
                message.style.opacity = "0";
                setTimeout(() => message.remove(), 500);
            }
        }, 3000);
    });
</script>

<!-- Responsive CSS -->
<style>
    .message-container {
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Mobile View */
    @media (max-width: 576px) {
        .message-container {
            width: 100%;
            font-size: 12px;
        }

        .alert {
            font-size: 12px;
            padding: 8px;
        }
    }
</style>


                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="row">
            <div class="col-md-12">
            <ul class="nav nav-pills custom-nav justify-content-center" id="productTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
            <i class="bi bi-card-text me-2"></i> Description
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="additionalInfo-tab" data-bs-toggle="tab" class="specification"             data-bs-target="#additionalInfo" type="button" role="tab" aria-controls="additionalInfo" aria-selected="false">
            <i class="bi bi-list-ul me-2"></i> Specification
        </button>
    </li>
</ul>

                <div class="tab-content mt-4">

       <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
    <div class="description-content">
        <h5 class="fw-bold text-center">Product Description</h5>
        <ul>
            @foreach(explode("\n", $product->description) as $point)
                @if(!empty(trim($point)))
                    <li>{{ trim($point) }}</li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

<div class="tab-pane fade" id="additionalInfo" role="tabpanel" aria-labelledby="specification-tab">
    <div class="specification-content">
        <h5 class="fw-bold specification">Product Specifications</h5>

        <!-- Desktop View -->
        <div class="d-none d-md-block">
            <table class="table table-striped table-hover">
                @if(!empty($specifications))
                    @foreach($specifications as $name => $value)
                        <tr>
                            <th class="fw-bold">{{ ucfirst($name) }}</th>
                            <td>{{ ucfirst($value) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center text-muted">No specifications available</td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- Mobile View (Accordion Style) -->
        <div class="d-block d-md-none">
    @if(!empty($specifications))
        <div class="accordion" id="specificationsAccordion">
            @foreach($specifications as $name => $value)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                        <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}"
                                aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                            {{ ucfirst($name) }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                         aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#specificationsAccordion">
                        <div class="accordion-body">
                            {{ ucfirst($value) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">No specifications available</p>
    @endif
</div>

<!-- JavaScript for Correct Toggle Behavior -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".accordion-button").forEach(function (button) {
            button.addEventListener("click", function () {
                let targetId = this.getAttribute("data-bs-target");
                let targetCollapse = document.querySelector(targetId);

                // Toggle manually
                if (targetCollapse.classList.contains("show")) {
                    targetCollapse.classList.remove("show");
                    this.classList.add("collapsed");
                } else {
                    document.querySelectorAll(".accordion-collapse").forEach(el => el.classList.remove("show"));
                    document.querySelectorAll(".accordion-button").forEach(btn => btn.classList.add("collapsed"));

                    targetCollapse.classList.add("show");
                    this.classList.remove("collapsed");
                }
            });
        });
    });
</script>


    </div>
</div>

                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <section class="main-content">
    <div class="container">
        <h4 class="title mb-4">Related Products</h4>

        <!-- Horizontal Scrollable for Mobile -->
        <div class="d-md-none">
            <div class="mobile-scroll-container">
                @foreach ($relatedProducts as $relatedProduct)
                <div class="mobile-product-box">
                    <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">
                        <div class="product-box text-center">
                            <img src="{{ Storage::url('app/public/' . $relatedProduct->product_image) }}"
                                class="img-fluid product-image"
                                alt="Related Product Image">
                            <h6 class="title mt-2 text-truncate" style="max-width: 100%;" title="{{ $relatedProduct->name }}">
                                {{ Str::limit($relatedProduct->name, 17) }}
                            </h6>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Bootstrap Carousel for Desktop -->
        <div id="related-products-carousel" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($relatedProducts->chunk(5) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                    <div class="row justify-content-center g-3">
                        @foreach ($chunk as $relatedProduct)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                            <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">
                                <div class="product-box text-center">
                                    <img src="{{ Storage::url('app/public/' . $relatedProduct->product_image) }}"
                                        class="img-fluid product-image"
                                        alt="Related Product Image">
                                    <h6 class="title mt-2 text-truncate" style="max-width: 100%;" title="{{ $relatedProduct->name }}">
                                        {{ Str::limit($relatedProduct->name, 17) }}
                                    </h6>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#related-products-carousel" data-bs-slide="prev">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left-circle">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                    </svg>
                </span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#related-products-carousel" data-bs-slide="next">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right-circle">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- JavaScript for Draggable Mobile Carousel -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let carousel = document.querySelector("#related-products-carousel");
        let startX = 0, endX = 0;

        carousel.addEventListener("touchstart", function(event) {
            startX = event.touches[0].clientX;
        });

        carousel.addEventListener("touchmove", function(event) {
            endX = event.touches[0].clientX;
        });

        carousel.addEventListener("touchend", function() {
            if (startX - endX > 50) {
                // Swipe left (Next)
                let nextButton = document.querySelector("#related-products-carousel .carousel-control-next");
                if (nextButton) nextButton.click();
            } else if (endX - startX > 50) {
                // Swipe right (Prev)
                let prevButton = document.querySelector("#related-products-carousel .carousel-control-prev");
                if (prevButton) prevButton.click();
            }
        });
    });
</script>

    </div>



<script>
    function formatIndianCurrency(amount) {
        let num = amount.toString().replace(/,/g, ''); // Remove existing commas
        let x = num.split('.');
        let x1 = x[0];
        let x2 = x.length > 1 ? '.' + x[1] : '';
        let lastThree = x1.substring(x1.length - 3);
        let otherNumbers = x1.substring(0, x1.length - 3);
        if (otherNumbers !== '') lastThree = ',' + lastThree;
        let formattedValue = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + x2;

        return formattedValue;
    }

    document.addEventListener("DOMContentLoaded", function () {
        let priceElement = document.getElementById("formattedPrice");
        let priceValue = priceElement.innerText.trim();
        let formattedPrice = formatIndianCurrency(priceValue);
        priceElement.innerText = formattedPrice;
    });
</script>


<script>
            document.getElementById('name').addEventListener('input', function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });
        </script>

<script>
function validateMessage(textarea) {
    if (textarea.value.length > 250) {
        textarea.value = textarea.value.substring(0, 250);
    }
}
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".nav-link");

    tabs.forEach(tab => {
        tab.addEventListener("mouseenter", function () {
            new bootstrap.Tab(tab).show();
        });

        tab.addEventListener("click", function () {
            new bootstrap.Tab(tab).show();
        });
    });
});
</script>
<script>
    function changeMainImage(thumbnail) {
        // Get the data-src attribute of the hovered thumbnail
        const newSrc = thumbnail.getAttribute('data-src');

        // Find the main image element and update its src
        const mainImage = document.getElementById('mainProductImage');
        mainImage.src = newSrc;
    }
</script>

<script>
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    const mainImage = document.getElementById("mainProductImage");
    const zoomResult = document.getElementById("zoomResult");

    mainImage.addEventListener("mouseenter", function() {
        zoomResult.style.display = "block";
        zoomResult.style.backgroundImage = `url(${mainImage.src})`;
    });

    mainImage.addEventListener("mousemove", function(event) {
        const rect = mainImage.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width) * 100;
        const y = ((event.clientY - rect.top) / rect.height) * 100;

        zoomResult.style.backgroundPosition = `${x}% ${y}%`;
        zoomResult.style.backgroundSize = "200%"; // Adjust zoom level
    });

    mainImage.addEventListener("mouseleave", function() {
        zoomResult.style.display = "none";
    });
});

</script>

<script>
    $(document).ready(function() {
        $('#addToCartForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: '{{ route('addToCart')}}', // The route to send the data to
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#successMessage').fadeIn().delay(3000).fadeOut(); // Show success message
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        });
    });
</script>
<script>
    function playVideo(videoSrc) {
    const videoPlayer = document.getElementById('modalVideoPlayer');
    videoPlayer.querySelector('source').src = videoSrc;
    videoPlayer.load(); // Load the video into the player
    const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
    videoModal.show(); // Show the modal
}

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const readMoreBtn = document.getElementById('readMoreBtn');
        if (readMoreBtn) {
            readMoreBtn.addEventListener('click', function () {
                const extraSpecs = document.querySelectorAll('.extra-specs');
                extraSpecs.forEach(item => item.classList.remove('d-none'));
                readMoreBtn.style.display = 'none'; // Hide the "Read More" button after clicking
            });
        }
    });
</script>


<script>
    function navigateToSpecification(event) {
        event.preventDefault(); // Prevent default anchor jump

        // Find the Specification tab button
        const specTab = document.querySelector('#additionalInfo-tab');
        if (specTab) {
            // Activate the tab using Bootstrap
            const tab = new bootstrap.Tab(specTab);
            tab.show();
        }

        // Scroll to the Specification section smoothly
        const section = document.querySelector('#additionalInfo');
        if (section) {
            const sectionPosition = section.getBoundingClientRect().top + window.scrollY;
            const scrollTarget = Math.max(sectionPosition - 150, 0); // Adjust scrolling to stop 150px before

            window.scrollTo({
                top: scrollTarget,
                behavior: 'smooth'
            });
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const videoModal = document.getElementById('videoModal');
        const modalVideoPlayer = document.getElementById('modalVideoPlayer');

        // Play video when the modal is shown
        videoModal.addEventListener('show.bs.modal', () => {
            modalVideoPlayer.play();
        });

        // Pause video when the modal is hidden
        videoModal.addEventListener('hide.bs.modal', () => {
            modalVideoPlayer.pause();
            modalVideoPlayer.currentTime = 0; // Reset video to the beginning
        });
    });
</script>


<script>
    function navigateToSpecification(event) {
        event.preventDefault(); // Prevent default anchor jump

        // Find the Specification tab button
        const specTab = document.querySelector('#additionalInfo-tab');
        if (specTab) {
            // Activate the tab using Bootstrap
            const tab = new bootstrap.Tab(specTab);
            tab.show();
        }

        // Scroll to the Specification section smoothly
        const section = document.querySelector('#additionalInfo');
        if (section) {
            const sectionPosition = section.getBoundingClientRect().top + window.scrollY;
            const scrollTarget = Math.max(sectionPosition - 150, 0); // Adjust scrolling to stop 150px before

            window.scrollTo({
                top: scrollTarget,
                behavior: 'smooth'
            });
        }
    }
</script>
<script>
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            let targetTab = this.getAttribute('data-bs-target');
            let tabButton = document.querySelector(`button[data-bs-target="${targetTab}"]`);
            if (tabButton) {
                new bootstrap.Tab(tabButton).show();
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var message = document.getElementById("success-message");
            if (message) {
                message.style.transition = "opacity 0.5s";
                message.style.opacity = "0";
                setTimeout(() => message.remove(), 500);
            }
        }, 3000);
    });
</script>

@include('frontend.parital.footer')
@endsection
