<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .container-fluid {
        height: 60px;
    }

    /* General styles */
    .category-img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        display: block;
        border-radius: 50%;
        margin: 0 auto;
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

       .category-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center the content horizontally */
        justify-content: center;
        /* Center the content vertically */
        text-align: center;
        width: 110px;
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

    .full-name {
        animation: none !important;
        transform: translateX(0) !important;
        text-align: center;
    }

    .navbar-nav .dropdown-toggle::after {
        display: none !important;
    }

    .dropdown-item1 {
        padding: 10px;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-item1:hover {
        background: #f8f9fa;
        color: rgb(145, 45, 232);
    }

    /* Basic Styling */
    .navbar-nav {
        position: relative;
    }

    /* Subcategory Container */
    .dropdown-menu {
        position: absolute;
        top: 100%;
        font-size: 11px;
        left: 0;
        display: none;
        min-width: 200px;
        flex-flow: column;
        background: white;
        border: 1px solid #ddd;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    /* Child Category Container */
    .child-category-list {
        position: absolute;
        flex-flow: column;
        top: 0;
        left: 100%;
        font-size: 11px;
        min-width: 200px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: none;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1100;
        height: 400px;
        max-width: auto;
    }

/* Ensure navbar and parent container allow dropdowns to be visible */
.main-navbar {
    position: relative;
    z-index: 1000; /* Ensure it's above other content */
}

/* Main category dropdown */
.nav-item.dropdown {
    position: relative;
}

/* Show subcategories on hover */
.nav-item.dropdown:hover > .dropdown-menu {
    display: block;
    margin-top: -10px;
    position: absolute;
    z-index: 1050 !important; /* Ensure it is above other content */
    background: white;
    min-width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

/* Subcategory items */
.dropdown-submenu {
    position: relative;
}

/* Show child categories on hover */
.dropdown-submenu:hover > .child-category-list {
    display: block;
    position: absolute;
    left: 100%;
    top: 0;
    z-index: 1100 !important; /* Ensure it's on top */
    background: white;
    min-width: 180px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    height: auto;   
}

/* Ensure dropdowns are always visible */
.child-category-list,
.subcategory-menu {
    display: none;
}

/* Show subcategory when hovering over its parent */
.nav-item.dropdown:hover .subcategory-menu {
    display: block !important;
}

/* Show child category when hovering over its parent */
.dropdown-submenu:hover .child-category-list {
    display: block !important;
}

/* Ensure no elements are hiding dropdowns */
body,
.container-fluid {
    overflow: visible !important;
}

/* Debugging: Outline dropdowns to check visibility issues */
.subcategory-menu,
.child-category-list {
    outline: 1px solid red; /* Remove after debugging */
}


    /* Subcategory & Childcategory Styling */
    .dropdown-item {
        padding: 10px;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: rgb(165, 61, 244);
    }

    .child-category-list {
        list-style: none;
        padding-left: 0;
        /* Removes default padding */
        margin: 0;
        /* Ensures no extra spacing */
    }

    .child-category-list li {
        list-style-type: none;
    }

 

    .arrow {
        cursor: pointer;
    }


    .title1 {
        height: 30px !important;
        cursor: pointer;
        font-size: 14px;
        margin-left: 10px;
    }


    .title1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 90%;
    }

    .title1 a {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .arrow {
        display: inline-flex;
        align-items: center;
        margin-left: px;
        /* Adjust if necessary */
    }


    /* Ensure the navbar is on top */
.mainnavbar {
    position: relative;
    z-index: 1050; /* Higher than the banner */
}

/* Ensure dropdown menu is visible and above other elements */
.navbar-nav .dropdown-menu {
    position: absolute;
    z-index: 11000 !important; /* Ensures it appears above the banner */
    display: none;
    background: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}

/* Make dropdown visible on hover */
.nav-item.dropdown:hover > .dropdown-menu {
    display: block;
}

/* Ensure child category list is also visible properly */
.child-category-list {
    position: absolute;
    left: 100%;
    top: 0;
    z-index: 10050 !important;
    background: white;
    display: none;
    min-width: 200px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

/* Show child category when hovering over subcategory */
.dropdown-submenu:hover > .child-category-list {
    display: block;
}

.nav-control {
    background-color: #A87676; /* Blue color */
    color: #ffffff; /* White text */
    border: none;
    
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 10px;
}

.nav-control:hover {
    background-color: #A87676; /* Darker blue on hover */
}

.nav-control:disabled {
    background-color: #A87676; /* Light gray when disabled */
    cursor: not-allowed;
    opacity: 0.6;
}

/* Align buttons properly */
.nav-control:first-child {
    margin-left: 0;
}

.nav-control:last-child {
    margin-right: 0;
}

/* Move dropdown menu to the left for the 7th and 8th categories */
/* Move dropdown menu to the left for the 7th and 8th visible categories */
.navbar-nav > .nav-item.shift-left .dropdown-menu {
    left: auto;
    right: 0;
    transform: translateX(0);
}

/* Move child categories inside subcategories to the left */
.navbar-nav > .nav-item.shift-left .dropdown-submenu .child-category-list {
    left: auto;
    right: 100%;
    position: absolute;
    top: 0;
    transform: translateX(0);
}


</style>


@include('frontend.parital.categorymobile')
@php
    $sortedCategories = $categories->sortBy('Category_name');
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light mainnavbar">
    <div class="container-fluid">
        <!-- Previous Button -->
        <button id="prev-btn" class="nav-control" disabled>&#8249; </button>

        <!-- Category List -->
        <ul class="navbar-nav category-list">
            @foreach($sortedCategories as $index => $category)
            <li class="nav-item dropdown category-item" data-index="{{ $index }}">
                <a class="nav-link dropdown-toggle" href="{{ route('products.category', $category->Category_name) }}" id="category-{{ $category->id }}" role="button" aria-expanded="false">
                    <div class="category-wrapper">
                        <img src="{{ $category->Category_image }}" alt="{{ $category->Category_name }}" class="category-img">
                        <div class="marquee-container">
                            <span class="category-name">{{ $category->Category_name }}</span>
                        </div>
                    </div>
                </a>
                @if($category->subcategories->isNotEmpty())
                <ul class="dropdown-menu">
                    @foreach($category->subcategories->sortBy('name') as $subcategory)  <!-- Sort subcategories -->
                    <li class="dropdown-submenu">
                        <a href="{{ route('products.subcategory', [$category->Category_name, $subcategory->name]) }}" class="dropdown-item">
                            {{ $subcategory->name }}
                            @if($subcategory->childcategories->isNotEmpty()) <span>></span> @endif
                        </a>
                        @if($subcategory->childcategories->isNotEmpty())
                        <ul class="child-category-list">
                            @foreach($subcategory->childcategories->sortBy('name') as $childcategory)  <!-- Sort child categories -->
                            <li>
                                <a href="{{ route('products.childcategory', [$category->Category_name, $subcategory->name, $childcategory->name]) }}" class="dropdown-item">
                                    {{ $childcategory->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>

        <!-- Next Button -->
        <button id="next-btn" class="nav-control">&#8250; </button>
    </div>
</nav>



 <!-- script for left right arrow-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const categories = document.querySelectorAll(".category-item");
    const prevBtn = document.getElementById("prev-btn");
    const nextBtn = document.getElementById("next-btn");
    let startIndex = 0;
    const batchSize = 8;

    function updateVisibility() {
        categories.forEach((item, index) => {
            item.style.display = (index >= startIndex && index < startIndex + batchSize) ? "block" : "none";
            item.classList.remove("shift-left"); // Reset previous shift-left class
        });

        // Add "shift-left" class to the 7th and 8th visible items
        let visibleCategories = [...categories].filter(item => item.style.display === "block");
        if (visibleCategories[6]) visibleCategories[6].classList.add("shift-left"); // 7th category
        if (visibleCategories[7]) visibleCategories[7].classList.add("shift-left"); // 8th category

        // Disable Previous button on the first section
        prevBtn.disabled = startIndex === 0;
        
        // Disable Next button on the last section
        nextBtn.disabled = startIndex + batchSize >= categories.length;
    }

    prevBtn.addEventListener("click", () => {
        if (startIndex > 0) {
            startIndex -= batchSize;
            updateVisibility();
        }
    });

    nextBtn.addEventListener("click", () => {
        if (startIndex + batchSize < categories.length) {
            startIndex += batchSize;
            updateVisibility();
        }
    });

    updateVisibility();
});
</script>


<!--marquee-content-->
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

<script>
    // Function to handle category navigation
    function navigateCategory(categoryId, categoryName, hasSubcategories) {
        if (hasSubcategories) {
            showSubmenu(categoryId);  // If there are subcategories, show submenu
        } else {
            window.location.href = '{{ url('products') }}/' + categoryName;  // Redirect to category page if no subcategories
        }
    }
</script>
