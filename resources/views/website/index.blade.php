@extends('frontend.layout')
@section('content')

@include('frontend.parital.topheader')

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    a {
        color: rgb(0, 0, 0);
        text-decoration: none !important;
    }

    .btn {
        background-color: #9055fd;
    }
</style>

<style>
    /* Mobile view: reduce banner height */
    @media (max-width: 768px) {
        #bannerCarousel .carousel-item img {
            height: 150px !important; /* Reduce height for mobile view */
        }
    }
</style>

<div id="wrapper" class="container">
    @include('frontend.parital.category')

    <section class="homepage-slider">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if($banners->isNotEmpty())
                    @foreach ($banners as $index => $banner)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/app/public/' . $banner->image_path) }}" class="d-block w-100" alt="Banner {{ $index + 1 }}">
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <p class="text-center">No banners available.</p>
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

    <div class="main">
 
    @foreach ($groupedProducts as $highlightName => $products)
            <section class="main-content p-3" style="background: linear-gradient(179.4deg, rgb(253, 240, 233) 2.2%, rgb(255, 194, 203) 96.2%); margin-bottom: -50px;">
                <div class="row">
                    <div class="col-12">
                        <h4 class="title mb-4 text-center">
                            {{ $highlightName }}
                            <span class="float-end">
                                <i class="bi bi-arrow-left-circle-fill text-secondary" data-bs-target="#carousel-{{ Str::slug($highlightName) }}" data-bs-slide="prev" style="font-size: 22px; cursor: pointer;"></i>
                                <i class="bi bi-arrow-right-circle-fill text-secondary" data-bs-target="#carousel-{{ Str::slug($highlightName) }}" data-bs-slide="next" style="font-size: 22px; cursor: pointer;"></i>
                            </span>
                        </h4>

                        @if ($products->isEmpty())
                            <div class="alert alert-warning text-center">
                                <strong>Product Not Found!</strong> Currently, there are no products available under {{ $highlightName }}.
                            </div>
                        @else
                            <div id="carousel-{{ Str::slug($highlightName) }}" class="carousel slide">
                                <div class="carousel-inner">
                                    @foreach ($products->chunk(6) as $chunk)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <div class="row">
                                                @foreach ($chunk as $product)
                                                <div class="col-6 col-md-2 mb-2">
    <a href="{{ route('product.detail', $product->id) }}">
        <div class="product-box text-center p-3 product-container"
             style="border: 1px solid #ddd; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-size: cover; background-repeat: no-repeat; height:215px; background: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);">
             
             @php
    $mainImage = asset('storage/app/public/' . ($product->product_image ?? 'default_product.jpg'));
    $galleryImages = $product->gallery_images ? json_decode($product->gallery_images, true) : [];
    $allImages = array_merge([$mainImage], array_map(fn($img) => asset('storage/app/public/' . $img), $galleryImages));
@endphp

<img src="{{ $mainImage }}"
     class="img-fluid rounded product-image"
     alt="{{ $product->name }}" 
     style="height:150px; width: 100%;"
     data-gallery='@json($allImages)'>


            <p class="mt-3 product-name" style="font-size: 14px; font-weight: 800; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $product->name }}">
                {{ Str::limit($product->name, 20) }}
            </p>
        </div>
    </a>
</div>

                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
            <br><br>

            @if ($loop->iteration == 2)
    @php
        $banners = \App\Models\HomepageBanner::all();
    @endphp
    @if ($banners->isNotEmpty())
        <div id="bannerCarousel" class="carousel slide my-4" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 15px; overflow: hidden;">
            <div class="carousel-inner" style="max-height: 200px; border-radius: 15px;">
                @foreach ($banners as $banner)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/app/public/' . $banner->image_path) }}" class="d-block w-100" alt="Homepage Banner" style="object-fit: fill; height: 150px; border-radius: 15px;">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif
@endif
        @endforeach

 
@php
    // Fetch banners from different tables
    $rightBanners = \App\Models\BottomBanner1::all()->shuffle();
    $leftBanners = \App\Models\BottomBanner::all()->shuffle(); // Fetch from bottom_banner1

@endphp

@if ($rightBanners->isNotEmpty() || $leftBanners->isNotEmpty())
    <div class="row my-4">
        <!-- Left Banner (From bottom_banner1 table) -->
        <div class="col-md-6">
            <div id="leftBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 15px; overflow: hidden;">
                <div class="carousel-inner" style="max-height: 200px; border-radius: 15px;">
                    @foreach ($leftBanners as $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ asset('storage//app/public/' . $banner->image) }}" class="d-block w-100" alt="Left Bottom Banner" style="object-fit: fill; height: 200px; border-radius: 15px;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Banner (From bottom_banners table) -->
        <div class="col-md-6">
            <div id="rightBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 15px; overflow: hidden;">
                <div class="carousel-inner" style="max-height: 200px; border-radius: 15px;">
                    @foreach ($rightBanners as $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ asset('storage/app/public/bottombanner1/' . $banner->image) }}" class="d-block w-100" alt="Right Bottom Banner" style="object-fit: fill; height: 200px; border-radius: 15px;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif


<style>
    /* Mobile view adjustments */
    @media (max-width: 768px) {
        /* Reduce banner height */
        #leftBannerCarousel .carousel-item img,
        #rightBannerCarousel .carousel-item img {
            height: 150px !important; /* Smaller height for mobile */
        }

        /* Make each banner container stack vertically */
        .col-md-6 {
            margin-bottom: 20px; /* Add some space between the two banner sections */
        }

.my-4 {
    margin-top: 1.5rem !important;
    margin-bottom: -0.5rem !important;
}
    }  
</style>

</div>


</div>

@include('frontend.parital.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".product-image").forEach(img => {
            let images = JSON.parse(img.getAttribute("data-gallery"));
            let index = 0;
            let interval;

            img.addEventListener("mouseenter", function () {
                interval = setInterval(() => {
                    index = (index + 1) % images.length;
                    img.src = images[index];
                }, 1000);
            });

            img.addEventListener("mouseleave", function () {
                clearInterval(interval);
                img.src = images[0]; // Reset to main image
            });
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".carousel").forEach(carousel => {
            let prevArrow = carousel.parentElement.querySelector(".bi-arrow-left-circle-fill");
            let nextArrow = carousel.parentElement.querySelector(".bi-arrow-right-circle-fill");
            let items = carousel.querySelectorAll(".carousel-item");

            if (items.length <= 1) {
                prevArrow.style.display = "none";
                nextArrow.style.display = "none";
            } else {
                prevArrow.style.display = "none";
                nextArrow.style.display = "block";
            }

            carousel.addEventListener("slid.bs.carousel", function () {
                let activeIndex = [...items].findIndex(item => item.classList.contains("active"));

                prevArrow.style.display = activeIndex === 0 ? "none" : "block";
                nextArrow.style.display = activeIndex === items.length - 1 ? "none" : "block";
            });
        });
    });
</script>

@endsection
