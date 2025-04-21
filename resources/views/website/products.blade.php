@extends('frontend.layout')
@section('content')

@include('frontend.parital.topheader')
<div id="wrapper" class="container">
    {!! view('frontend.parital.categorylisting')->render() !!}

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
                height: 135px;
                width: 140px;
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
            min-height: 80vh;
            /* Ensures content area takes at least 80% of viewport height */
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
            background-color: rgb(255, 255, 255);
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
            object-fit: fill;
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
            object-fit: fill;
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


        /* Hover effect on image */
        /* .product-box:hover .product-image {
        transform: scale(1.1);
        opacity: 0.8;
    } */

        /* Product box hover effect */
        /* .product-box:hover {
        transform: translateY(-8px); 
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    } */

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

        .marquee-container {
            width: 126px;
            /* Take full width of parent */
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .marquee-content {
            display: inline-block;
            position: relative;
            transform: translateX(100%);
            animation: smoothMarquee 10s linear infinite;
        }





        @keyframes smoothMarquee {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }


        .category-name {
            text-align: center;
            margin-top: 3px;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80px;
        }


        /* Price and old price styling */
        /* .price {
        font-size: 1.3rem;
        color: #333;
        font-weight: 700;
        margin-top: 10px;
    } */

        /* .old-price {
        font-size: 1rem;
        color: #aaa;
        text-decoration: line-through;
        margin-left: 8px;
    } */

        /* Responsive design */
        @media (max-width: 767px) {
            .product-box {
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .product-image {
                transition: transform 0.3s ease;
            }

            .product-box:hover .product-image {
                transform: scale(1.05);
            }

            .mobile-category-container {
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px 0;
                background: #fff;
            }

            .mobile-category-scroll {
                margin-top: 20px;
                display: flex;
                gap: 15px;
                padding: 0 10px;
            }

            .mobile-category-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                min-width: 80px;
                text-decoration: none;
                color: #333;
            }

            .mobile-category-image {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease-in-out;
            }

            .mobile-category-name {
                margin-top: 5px;
                font-size: 12px;
                font-weight: 500;
                white-space: normal;
            }

            /* Highlight Active Category with Border */
            .active-category .mobile-category-image {
                border: 3px solid #ff9900;
                /* Change color to match your theme */
                padding: 2px;
            }

            .content {
                padding: 10px;
                text-align: center;
                margin-top: -35px;
                width: 160px;
                margin-left: -8px;
            }
            .banner-img{
                margin-top: 10px;
            }


        }

        .price::before {
            content: "₹ ";
            font-weight: bold;
        }

        .banner-img {
    height: 150px; /* Adjust to your desired height */
    object-fit: cover; /* Ensures the image is cropped instead of squished */
    margin-bottom: 20px; /* Adds space below the banner */
    width: 1500px;
    border-radius: 20px; /* Adjust the value for more or less curvature */
}

@media (max-width: 768px) {
    .product-name {
        display: block;
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 15ch; /* Limits to 15 characters */
    }
}




        
    </style>

    <!-- Mobile View: Amazon-Style Horizontal Scroll -->
    <div class="d-block d-md-none mobile-category-container">
        <div class="mobile-category-scroll">
            @foreach($childCategories as $child)
            <a href="{{ route('products.byChildCategory', [
                    $child->subcategory->category ? $child->subcategory->category->Category_name : 'Unknown Category', 
                    $child->subcategory ? $child->subcategory->name : 'Unknown Subcategory', 
                    $child->name
                ]) }}"
                class="mobile-category-item 
                    {{ isset($selectedChildCategory) && $selectedChildCategory->id == $child->id ? 'active-category' : '' }}">

                <img src="{{ '/' }}images/default8.png"
                    alt="{{ $child->name }}"
                    class="mobile-category-image">
                <div class="marquee-container">
                    <span class="mobile-category-name category-name">{{ $child->name }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <section class="homepage-slider">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" style="margin-top: 10px; ">
    @if(isset($banners) && $banners->isNotEmpty())
        @foreach ($banners as $index => $banner)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/app/public/' . $banner->banner) }}"
                    class="d-block mx-auto"
                    alt="Banner {{ $index + 1 }}"
                    style="width: 100%; height: 150px; object-fit: fill; border-radius: 10px;">
            </div>
        @endforeach
    @else
        <div class="carousel-item active">
         
        </div>
    @endif
</div>



            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>








    <section class="header_text sub">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                @if(request('category'))
                <li class="breadcrumb-item"><a href="{{ route('products.category', ['category' => request('category')]) }}">{{ request('category') }}</a></li>
                @endif
                @if(request('subcategory'))
                <li class="breadcrumb-item"><a href="{{ route('products.subcategory', ['category' => request('category'), 'subcategory' => request('subcategory')]) }}">{{ request('subcategory') }}</a></li>
                @endif
                @if(request('childcategory'))
                <li class="breadcrumb-item active" aria-current="page">{{ request('childcategory') }}</li>
                @endif
            </ol>
        </nav>

    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="row">
            <!-- Side Menu -->
            <!-- Desktop View: Keep Your Existing Code Unchanged -->
            <div class="col-lg-3 col-md-4 d-none d-md-block">
                <div class="list-group custom-list">
                    @foreach($childCategories as $child)
                    <a href="{{ route('products.byChildCategory', [
                    $child->subcategory->category ? $child->subcategory->category->Category_name : 'Unknown Category', 
                    $child->subcategory ? $child->subcategory->name : 'Unknown Subcategory', 
                    $child->name
                ]) }}"
                        class="list-group-item 
                    {{ isset($selectedChildCategory) && $selectedChildCategory->id == $child->id ? 'active' : '' }}
                    {{ !isset($selectedChildCategory) && $loop->first ? 'active' : '' }}">
                        {{ $child->name }}
                    </a>
                    @endforeach
                </div>
            </div>



            <!-- Products Section -->
            <div class="col-lg-9 col-md-8">
    <div class="row">
        @php
            $bannerDisplayed = false;
            $secondRowHasProducts = false;

            // Get the category ID from the first product if available
            $category_id = $products->first()->categoryid ?? null;

            // Fetch a banner related to this category
            $banner = null;
            if ($category_id) {
                $banner = \App\Models\ListingBanner::where('category_id', $category_id)
                    ->whereNotNull('banner_image')
                    ->first();
            }
        @endphp

        @forelse($products as $index => $product)
            {{-- Identify if the 2nd row contains at least one product --}}
            @if ($index >= 4 && $index <= 7)
                @php $secondRowHasProducts = true; @endphp
            @endif

            <div class="col-lg-3 col-md-3 col-sm-6 col-6 d-flex">
                <div class="product-box w-100">
                    <a href="{{ route('product.detail', $product->id) }}">
                        <img src="{{ asset('storage/app/public/' . ($product->product_image ?? 'default_product.jpg')) }}"
                            alt="{{ $product->name }}" class="product-image">
                    </a>
                    <div class="content">
                    <h5 class="title">
    <a href="{{ route('product.detail', $product->id) }}" title="{{ $product->name }}" 
       class="product-name" data-fullname="{{ $product->name }}">
        {{ \Illuminate\Support\Str::limit($product->name, 20, '...') }}
    </a>
</h5>



                        <p class="price" id="formattedPrice">{{ $product->sales_price }}</p>
                    </div>
                </div>
            </div>

            {{-- Display category-specific banner after last product in the 2nd row --}}
            @if ($secondRowHasProducts && !$bannerDisplayed && ($index == 7 || $loop->last) && $banner)
                <div class="col-12 text-center mb-4">
                    <img src="{{ asset('storage/app/public/' . $banner->banner_image) }}" 
                        alt="Banner" class="img-fluid banner-img" style="object-fit: fill;">
                </div>
                @php $bannerDisplayed = true; @endphp
            @endif

        @empty
            <div class="col-12">
                <p class="text-center">No products found.</p>
            </div>
        @endforelse
    </div>
</div>










        </div>
    </section>


</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateProductNames() {
            let productLinks = document.querySelectorAll('.product-name');
            productLinks.forEach(link => {
                let fullName = link.getAttribute('data-fullname');
                if (window.innerWidth <= 768) { // Mobile View
                    link.textContent = fullName.length > 15 ? fullName.substring(0, 15) + '...' : fullName;
                } else { // Desktop View
                    link.textContent = fullName.length > 20 ? fullName.substring(0, 20) + '...' : fullName;
                }
            });
        }

        // Run function on page load and resize
        updateProductNames();
        window.addEventListener("resize", updateProductNames);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let productLinks = document.querySelectorAll('.product-name');

        productLinks.forEach(link => {
            let fullName = link.getAttribute('data-fullname');
            if (window.innerWidth <= 768) { // Mobile View
                link.textContent = fullName.length > 15 ? fullName.substring(0, 15) + '...' : fullName;
            }
        });
    });
</script>

<script>
    function formatIndianCurrency(amount) {
        // Ensure the amount is a valid number and remove any non-numeric characters (except ".")
        let num = amount.toString().replace(/,/g, '').trim();
        if (isNaN(num) || num === '') return amount; // Return original if not a valid number

        let parts = num.split('.');
        let integerPart = parts[0]; // Whole number part
        let decimalPart = parts.length > 1 ? '.' + parts[1] : ''; // Decimal part

        let lastThree = integerPart.slice(-3);
        let otherNumbers = integerPart.slice(0, -3);

        if (otherNumbers !== '') lastThree = ',' + lastThree;
        let formattedValue = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + decimalPart;

        return formattedValue;
    }

    document.addEventListener("DOMContentLoaded", function() {
        let priceElements = document.querySelectorAll(".price"); // Select all elements with class "price"

        priceElements.forEach(function(element) {
            let priceValue = element.textContent.trim();
            let formattedPrice = formatIndianCurrency(priceValue);
            element.textContent = formattedPrice;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categories = document.querySelectorAll('.category-name');

        categories.forEach(category => {
            const categoryName = category.textContent.trim();

            if (categoryName.length > 16) {
                category.style.display = 'inline-block';
                category.style.whiteSpace = 'nowrap';
                category.style.overflow = 'hidden';
                category.style.width = '200px'; // Adjust width

                // Wrap the text inside a scrolling span
                category.innerHTML = `<span class="marquee-content">${categoryName}</span>`;
                const marqueeContent = category.querySelector('.marquee-content');

                let scrollCount = 0;
                const maxScrolls = 1; // Number of times to scroll before pausing
                const pauseTime = 3000; // Pause duration (3 seconds)
                const animationDuration = 4; // Adjust scrolling speed

                marqueeContent.style.display = 'inline-block';
                marqueeContent.style.position = 'relative';
                marqueeContent.style.animation = `smoothMarquee ${animationDuration}s linear infinite`;

                let lastOffset = 0;

                marqueeContent.addEventListener("animationiteration", function() {
                    scrollCount++;
                    if (scrollCount >= maxScrolls) {
                        marqueeContent.style.animationPlayState = 'paused';

                        // Capture the current transform position
                        const computedStyle = window.getComputedStyle(marqueeContent);
                        const matrix = new WebKitCSSMatrix(computedStyle.transform);
                        lastOffset = matrix.m41; // Get the translateX value

                        setTimeout(() => {
                            scrollCount = 0;
                            marqueeContent.style.animation = 'none'; // Stop the current animation
                            marqueeContent.style.transform = `translateX(${lastOffset}px)`; // Maintain position

                            setTimeout(() => {
                                marqueeContent.style.animation = `smoothMarquee ${animationDuration}s linear infinite`;
                            }, 10); // Small delay to restart animation
                        }, pauseTime);
                    }
                });

                category.addEventListener('mouseenter', function() {
                    marqueeContent.style.animationPlayState = 'paused';
                });

                category.addEventListener('mouseleave', function() {
                    marqueeContent.style.animationPlayState = 'running';
                });
            }
        });
    });
</script>

<style>
    @keyframes smoothMarquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-100%);
        }
    }
</style>


@include('frontend.parital.footer')
@endsection