@extends('frontend.layout')
@section('content')

    <style>
.sticky-header {
    position: sticky;
    top: 0;
  
    padding: 10px 0;
    z-index: 100;  /* Ensure it's lower than dropdown */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    display:inline;
    justify-content: center;
    align-items: center;
    flex-direction: column; /* Makes sure the strip-container stays inside */
}

.button-sticky-header {
    position: sticky;
    top: 50px; /* Adjust if needed */
    padding: 10px 0;
    z-index: 200; /* Ensure it's above other elements */
    background: transparent; /* Remove white background */
    box-shadow: none; /* Remove shadow if not needed */
    display: flex;
    flex-direction: column;
}


.strip-container-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    background: transparent !important;
}

.strip-container {
    margin-top: 20px;
    position: relative;
    display: inline-block;
    background: linear-gradient(179.4deg, rgb(230, 174, 230) 2.2%, rgb(203, 138, 175) 96.2%);
    color: white;
    padding: 12px 25px;
    font-weight: bold;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    max-width: 90%; /* Prevents overflow */
}

/* Ribbon effect */
.strip-container::before,
.strip-container::after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    background: inherit;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.1);
}

.strip-container::before {
    left: -10px;
}

.strip-container::after {
    right: -10px;
}

/* Ensure dropdown is on top */
.category-dropdown {
    position: absolute !important;
    z-index: 9999 !important;
    background: white;
    border: 1px solid #ddd;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}



    </style>
    <style>
        /* General Styles */
        html {
            scroll-behavior: smooth;
        }

        /* Product Title */
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 10px 0 5px;
            line-height: 1.4;
            text-align: left;
            display: block;
        }

        .title:hover {
            color: #ff5722;
        }

        /* Price Styling */
        .price {
            font-size: 16px;
            font-weight: bold;
            color: #d9534f;
            margin-bottom: 5px;
            margin-left: -25px !important;
        }

        .old-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
            margin-left: 5px;
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            font-size: 14px;
            color: #555;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            padding: 8px 12px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff5722;
            color: #fff;
            border-color: #ff5722;
        }

        .pagination .page-item .page-link:hover {
            background-color: #ff5722;
            color: #fff;
        }

        .pagination .page-link:focus {
            outline: none;
            box-shadow: 0 0 5px 2px rgba(255, 87, 34, 0.5);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .product-box img {
                height: 180px;
            }

            .product-box {
                padding: 10px;
            }

            .title {
                font-size: 14px;
                word-wrap: break-word;
            }

            .price {
                font-size: 16px;
            }
        }
        
        
        #wrapper {
    min-height: 80vh; /* Ensures content area takes at least 80% of viewport height */
    display: flex;
    flex-direction: column;
}

        /* Keyframes for Animation */
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <style>
        .breadcrumb {
            font-size: 11px;
            /* Reduce font size */
            padding: 0.2rem 0;
            /* Reduce padding */
        }

        .breadcrumb-item a {
            font-size: 11px;
            /* Reduce link font size */
        }

        .breadcrumb-item {
            padding: 0.2rem 0.5rem;
            /* Reduce item padding */

        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: " > ";
            /* Change separator to '>' */
        }
    </style>

    <style>
        /* Container with smooth scroll */
        .custom-list {
            width: 235px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
            scroll-behavior: smooth;
            /* Smooth scroll behavior */
            border-radius: 6px;
            background-color: #fff !important;
            /* Clean white background */
            border: 1px solid #e5e5e5;
            /* Light border for a sleek look */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            /* Subtle box-shadow */
            transition: box-shadow 0.2s ease;
        }

        /* Styling for smooth thin scrollbar */
        .custom-list::-webkit-scrollbar {
            width: 1px;
        }

        .custom-list::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 4px;
        }

        .custom-list::-webkit-scrollbar-track {
            background: #f4f4f4;
        }

        /* Styling for list items */
        .list-group-item {
            background-color:rgb(255, 255, 255);
            border: 1px solid #f1f1f1;
            padding: 7px 15px;
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
            /* Smooth transition for hover and active */
            cursor: pointer;
            /* Pointer cursor for clickability */
        }



        /* Active item styling */
        .list-group-item.active {
            background: linear-gradient(270deg, #f7e4ff 73.74%, #f0ccff);
            color: #7c0ab1;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
    /* 
            .list-group-item.active:hover {
                color: black;
            } */

        /* Heading styling */
        .list-group h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-left: 30px;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 767px) {
            .list-group-item {
                font-size: 0.9rem;
                /* Adjust font size for mobile */
            }

            .custom-list {
                max-height: 250px;
                /* Adjust container height for smaller screens */
            }
        }
    </style>

    <style>

        /* Discount tag */
        .discount-tag {
            position: absolute;
            background-color: #ff4f58;
            color: white;
            padding: 5px 5px;
            font-size: 10px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Image styling - set width and height to 100x100 */
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            /* Ensure image aspect ratio is preserved */
            display: block;
            margin: 0 auto;
            border-bottom: 2px solid #e3e4e8;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* General Styling */
        .product-list {
            margin: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            background-color: #fff;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #a29bfe;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .product-details {
            padding: 10px 0;
        }

        .product-details h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-details p {
            font-size: 14px;
            color: #666;
        }

        .price {
            margin: 10px 0;
        }

        .new-price {
            font-size: 18px;
            color: #e74c3c;
            font-weight: bold;
        }

        .old-price {
            text-decoration: line-through;
            font-size: 16px;
            color: #888;
            margin-left: 10px;
        }

        .add-to-cart {
            background-color: #ff6f61;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: #e84c3b;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .product-card {
                margin-bottom: 20px;
            }
        }



        /* Title and content */
        .content {
            padding: 15px;
            text-align: center;
            margin-top: -35px;
            width: 250px;
            margin-left: -23px;
        }

        /* Title styling */
        .content .title a {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
            margin-left: 23px;
        }

        /* Title hover effect */
        .content .title a:hover {
            color: #0056b3;
        }

        .list-group.custom-list a:hover {
    background-color: transparent !important;
    color: inherit !important;
    text-decoration: none !important;
}


        /* Responsive design */
        @media (max-width: 767px) {
            .product-box {
                width: 200px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin-left:-10px;
            }

            .product-image {
                transition: transform 0.3s ease;
            }

            .product-box:hover .product-image {
                transform: scale(1.05);
            }
        }




        /* Responsive adjustments */
@media (max-width: 767px) {
    /* Adjust product box padding and border radius */
    .product-box {
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Responsive product image */
    .product-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-box:hover .product-image {
        transform: scale(1.05);
    }

    /* Adjust product title size */
    .title {
        font-size: 14px;
        word-wrap: break-word;
    }

    /* Adjust price font size */
    .price {
        font-size: 14px;
        margin-left: 0px !important;
    }

    /* Adjust pagination for small screens */
    .pagination {
        flex-wrap: wrap;
    }

    .pagination .page-item .page-link {
        font-size: 12px;
        padding: 6px 10px;
    }

    /* Adjust discount tag size */
    .discount-tag {
        font-size: 9px;
        padding: 4px 4px;
    }

    /* Adjust list container */
    .custom-list {
        width: 100%;
        max-height: 300px;
        padding-right: 5px;
    }

    /* Adjust list items */
    .list-group-item {
        font-size: 11px;
        padding: 5px 10px;
        margin-bottom: 5px;
    }

    /* Sticky header adjustments */
    .sticky-header {
        padding: 5px 0;
    }

    /* Responsive button styles */
    .toggle-btn {
        padding: 5px 15px;
        font-size: 14px;
    }

    /* Ensure content wrapper maintains spacing */
    #wrapper {
        min-height: 70vh;
    }

    /* Breadcrumb font size adjustment */
    .breadcrumb {
        font-size: 10px;
    }

    .breadcrumb-item a {
        font-size: 10px;
    }

    /* Adjust spacing for better touch targets */
    .product-details h5 {
        font-size: 16px;
    }

    .product-details p {
        font-size: 12px;
    }

    /* Button size adjustments */
    .add-to-cart {
        padding: 8px 15px;
        font-size: 14px;
    }


    
}

@media (max-width: 768px) {
    .toggle-container {
        margin-top: 20px; /* Default margin */
        transition: margin-top 0.3s ease-in-out;
    }
}


  </style>

@include('frontend.parital.topheader')
<div id="wrapper" class="container">
{!! view('frontend.parital.categorylisting')->render() !!}


<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <br>
        <!-- Sticky Header Container -->
        <div class="sticky-header">
            <!-- Centered Strip Container -->
            <div class="strip-container-wrapper">
                <div class="strip-container">
                    <h5 class="mb-0">
                        Products/Services of {{ $member->first_name }} - 
                        {{ Str::limit($member->company_name, 40, '...') }} - 
                        {{ $member->phone_number }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="button-sticky-header">
            <!-- Toggle Buttons Below the Header -->
            <div class="toggle-container" style="margin-top: 20px; margin-left: 10px; display: flex; align-items: center;">
                <button id="toggle-products"
                    style="background-color: rgb(177, 96, 248); color: white; border: 2px solid rgb(177, 96, 248); 
                        padding: 6px 20px; border-radius: 8px; transition: 0.3s; margin-right: 5px;">
                    Products
                </button>

                <button id="toggle-services"
                    style="background-color: white; color: rgb(177, 96, 248); border: 2px solid rgb(177, 96, 248);
                        padding: 6px 20px; border-radius: 8px; transition: 0.3s;">
                    Services
                </button>
            </div>
        </div>
        <br>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <!-- Products Section -->
                <div id="products-section" style="display:block;">
                    @if($products->count() > 0)
                        <div class="row justify-content-center">
                            @foreach($products as $product)
                                <div class="col-md-2 mx-2 col-sm-4 col-6 mb-4">
                                    <div class="product-box">
                                        <a href="{{ route('product.detail', $product->id) }}">
                                            <img src="{{ asset('storage/app/public/' . ($product->product_image ?? 'default_product.jpg')) }}" 
                                                alt="{{ $product->name }}" 
                                                class="product-image">
                                        </a>
                                        <div class="content">
                                            <h5 class="title">
                                                <a href="{{ route('product.detail', $product->id) }}" title="{{ $product->name }}">
                                                    {{ \Illuminate\Support\Str::limit($product->name, 20, '...') }}
                                                </a>
                                            </h5>
                                            <p class="price">{{ $product->sales_price }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No products found.</p>
                    @endif
                </div>

                <!-- Services Section (Initially Hidden) -->
                <div id="services-section" style="display:none;">
                    @if($services->count() > 0)
                        <div class="row justify-content-center">
                            @foreach($services as $service)
                                <div class="col-md-2 mx-2 col-sm-4 col-6 mb-4">
                                    <div class="product-box">
                                        <a href="{{ route('product.detail', $service->id) }}">
                                            <img src="{{ asset('storage/app/public/' . ($service->product_image ?? 'default_service.jpg')) }}" 
                                                alt="{{ $service->name }}" 
                                                class="product-image">
                                        </a>
                                        <div class="content">
                                            <h5 class="title">
                                                <a href="{{ route('product.detail', $service->id) }}" title="{{ $service->name }}">
                                                    {{ \Illuminate\Support\Str::limit($service->name, 20, '...') }}
                                                </a>
                                            </h5>
                                            <p class="price">{{ $service->sales_price }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No services found.</p>
                    @endif
                </div>

                <!-- Pagination -->
                <hr>
              
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    let toggleContainer = document.querySelector(".toggle-container");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) { // Adjust threshold as needed
            toggleContainer.style.marginTop = "40px";
        } else {
            toggleContainer.style.marginTop = "30px";
        }
    });
});

</script>

<!-- JavaScript for Toggle -->
<script>
document.getElementById('toggle-products').addEventListener('click', function () {
    document.getElementById('products-section').style.display = 'block';
    document.getElementById('services-section').style.display = 'none';
    this.classList.add('active');
    document.getElementById('toggle-services').classList.remove('active');
});

document.getElementById('toggle-services').addEventListener('click', function () {
    document.getElementById('products-section').style.display = 'none';
    document.getElementById('services-section').style.display = 'block';
    this.classList.add('active');
    document.getElementById('toggle-products').classList.remove('active');
});
</script>


<script>
    function formatIndianCurrency(amount) {
        // Convert to number and remove decimals
        amount = Math.floor(amount);

        // Convert number to Indian format using regex
        return amount.toLocaleString('en-IN');
    }

    // Apply formatting after the page loads
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".price").forEach(function (el) {
            let amount = el.innerText.replace(/[^\d]/g, ""); // Extract numeric value
            el.innerText = "₹ " + formatIndianCurrency(amount);
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const productsButton = document.getElementById("toggle-products");
    const servicesButton = document.getElementById("toggle-services");
    const productsSection = document.getElementById("products-section");
    const servicesSection = document.getElementById("services-section");

    function showProducts() {
        productsSection.style.display = "block";
        servicesSection.style.display = "none";
        productsButton.style.backgroundColor = "rgb(177, 96, 248)";
        productsButton.style.color = "white";
        servicesButton.style.backgroundColor = "white";
        servicesButton.style.color = "rgb(177, 96, 248)";
    }

    function showServices() {
        productsSection.style.display = "none";
        servicesSection.style.display = "block";
        servicesButton.style.backgroundColor = "rgb(177, 96, 248)";
        servicesButton.style.color = "white";
        productsButton.style.backgroundColor = "white";
        productsButton.style.color = "rgb(177, 96, 248)";
    }

    productsButton.addEventListener("mouseenter", showProducts);
    servicesButton.addEventListener("mouseenter", showServices);
});
</script>


</div>

@include('frontend.parital.footer')
@endsection