@extends('frontend.layout')
@section('content')

    @include('frontend.parital.topheader')

    <style>


        @media (max-width: 600px) {

        .mainnavbar {
            display: none;
        }
        .mobile {
            display: flex !important;
            flex-direction: column;
            gap: 15px;
            background-color: white;
        }
        .category-row {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap:25px;
            padding-top: 5px;
            scrollbar-width: none;
        }
        .category-row::-webkit-scrollbar {
            display: none;
        }
        .category-wrapper {
            flex: 0 0 auto;
            scroll-snap-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 80px;
        }
        .category-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ab7878;
            background-color: #091016;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.4), inset -2px -2px 5px rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .category-img:hover {
            transform: scale(1.1);
            box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.5), inset -2px -2px 8px rgba(255, 255, 255, 0.6);
        }
        .category-name {
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-top: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80px;
            white-space: normal;
            text-align: center;
        }
        a {
            text-decoration: none;
            color:black;
        }

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


    </style>



<div class="mobile shadow-lg mb-1 p-1 rounded" style="display: none">
    <h2><a href="{{ url('/') }}" class="btn btn-white text-black">
        ←
    </a>{{$category->Category_name}}</h2>

        @if($subcategories->isEmpty())
            <p>No subcategories available.</p>
        @else
            <div class="category-row">
                @foreach($subcategories as $subcategory)

                    <div class="category-wrapper">

                        <a href="{{ url('/childcategoriesm/' . $subcategory->id) }}">
                            <img src="{{ '/' }}images/default3.png" class="category-img" alt="{{ $subcategory->name }}">
                        </a>
                        <div class="marquee-container">
                        <span class="category-name" >{{ $subcategory->name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


        <div class="container" @if ($product->isEmpty()) style="height: 450px;"@endif>

            @if (!$product->isEmpty())
            <div class="row">
                @foreach ($product as $item)
                    <div class="col-6 col-md-4 mb-2 p-1">
                        <a href="{{ route('product.detail', $item->id) }}" class="text-decoration-none text-dark">
                            <div class="card p-2" style="background: linear-gradient(106.5deg, rgba(255, 215, 185, 0.91) 23%, rgba(223, 159, 247, 0.8) 93%);">
                                <img src="{{ asset('storage/app/public/' . $item->product_image) }}"
                                    class="card-img-top"
                                    alt="{{ $item->name }}"
                                    style="width: 100%; height: 200px; object-fit: cover;">

                                <div class="card-body text-center p-2">
                                    <h6 class="card-title mb-1">
                                        {{ Str::limit($item->name, 10, '...') }}
                                    </h6>
                                    <p class="card-text mb-0"><strong>Price:</strong> ₹{{ number_format($item->sales_price) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @else
                <p>No products available.</p>
            @endif
        </div>




 </div>


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
