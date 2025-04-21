<!DOCTYPE html>
<html lang="en">

<head>
   
<link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIEPMD</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>

        .container-fluid {
            height: 180%;
            overflow-x:hidden;
           
        }


        /* Sidebar styling */
        nav {
            height: 100%;
            position: fixed !important;
            top: 50px;
            /* Adjust for header height */
            bottom: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(to right, #1d2b64, #f8cdda);
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: rgb(222, 222, 222);
            color: black;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
        }

        .vendor-icon {
            width: 40px;
            height: 40px;
            background-color: rgb(231, 229, 229);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }



        .vendor-icon:hover .tooltip-text {
            height: 100px;
        }



        /* Main content area */
        main {
            margin-left: 250px;
            margin-top: 50px;
            padding: 20px;
        }

        /* Styling for sidebar links */
        .nav-link {
            color: black !important;
            padding: 10px;
        }

        .nav-link:hover {
            background-color: rgb(212, 200, 239);
            border-bottom-right-radius: 25px;
            border-top-right-radius: 25px;
        }

        /* Style for nested submenus */
        .submenu {
            display: none;
            padding-left: 20px;
        }

        .nav-item.active .submenu {
            display: block;
        }

        .nav-item .nav-link::after {
            content: ' ▼';
            font-size: 0.8em;
        }

        .nav-item.active .nav-link::after {
            content: ' ▲';
        }

        .nav-link.active {
            background-color: rgb(168, 130, 250) !important;
            /* Highlight color */
            color: white !important;
            border-bottom-right-radius: 25px;
            border-top-right-radius: 25px;
            /* Text color change */
        }
     
        #sidebar a {
            font-size:14px;
        }
    </style>
    <style>
        .footer {
            background-color: #f8f9fa;
            /* Optional: add a background color if needed */
            padding: 1rem 0;
            position: fixed !important;
        }

        .footer .text-black {
            color: black;
        }

        .footer .text-center {
            text-align: center;
        }

        .rounded-circle {
            width: 50px;
            height: 47px;
        }

        #logout {
            text-decoration: none;
            margin-left: -29px;
            font-weight: 600;
        }

        html, body {
    height: 100%;
}
body {
    display: flex;
    flex-direction: column;
}
.content {
    flex: 1; /* Pushes footer down */
}
.footer {
    font-size: 12px;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: white; /* Ensure background color */
    text-align: center;
    padding: 10px 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow effect */

}

.companyname{
    margin-left:-650px;
}
.adminname{
    transform: translateX(-285px);
}

.vendoricon{
    margin-left:-20px;
    margin-top:14px;
    width:40px;
    height:40px;
    border-radius:50%;
}
         /* Sidebar styles */
         #sidebar {
            height: 100vh;
            background:rgb(64, 52, 58);
            color: white;
            transition: 0.3s;
        }
        #sidebar a {
            color: white !important;
            font-size: 12px !important;
            text-decoration: none !important;
            padding: 10px !important;
            display: block !important;
            margin-left:-20px !important;
            border-top-right-radius: 25px !important;
           border-bottom-right-radius: 25px !important;
        }
        #sidebar a:hover {
            background:#e0c1d7;
            color: black !important;
        }

        .text-white a:hover{
            color: black;
        }
        /* Responsive sidebar */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                transition: 0.3s;
                z-index: 1000;
            }
            #sidebar.active {
                left: 0;
            }
            #main-content {
                margin-left: 0 !important;
            }
        .image{
            border-radius:50%;
            height: 55px;
        width: 55px;
        margin-left: 20px;

        }
            .companyname{
    margin-left:-30px;
    font-size:11px;
}

.footer {
    font-size: 12px;
    position: fixed !important;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: white; /* Ensure background color */
    text-align: center;
    padding: 10px 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow effect */

}

#sidebar a {
    transform: translateY(65px);
}
        }
        @media (min-width: 769px) {
            .mobile-admin {
                display: none !important;
            }
        }

        
    </style>

    <style>
        /* Desktop View: Align Vendor Icon, Admin Info, and Company Logo */
@media (min-width: 768px) {
    .d-md-flex {
        display: flex;
        align-items: center;
    }

    .vendor-icon img {
        width: 80px;
        height: auto;
    }

    .text-white strong {
        font-size: 16px;
        
    }

    .text-white img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .companyname {
        font-weight: bold;
        color: white;
        font-size:11px;
    }

    .company-details img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
    }
}



/* Mobile View: Keep Company Name & Logo Centered */
@media (max-width: 767px) {
    .d-md-none {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-left: 244px;
    }

    .d-md-none img {
        width: 40px;
        height: 40px;
    }

    #toggleSidebar {
        position: absolute;
        right: 15px;
        top: 10px;
    }
    .admin{
        margin-left:0px;
        margin-top: -77px;
    }
    .company{
margin-top:70px;
font-size:11px;
margin-left: -105px;
    }
}


.bg-dark {
    background: linear-gradient(to right, #1d2b64, #f8cdda) !important;
}


    </style>
</head>

<body>
    <!-- Top Header -->
    <div class="container-fluid">
    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center bg-dark text-white p-3">
        <!-- Left Section: Vendor & Admin Info (Visible on Desktop) -->
        <div class="d-none d-md-flex justify-content-center align-items-center" style="width: 100%;margin-left:100px;">
    <span class="text-white">
        <strong class="companyname">{{ auth('vendor')->user()->company_name }}</strong>
    </span>
</div>
 
        <!-- Mobile View: Company Name & Logo (Only for Mobile) -->
        <div class="d-md-none">
            <span class="text-white">
                <strong class="companyname">{{ auth('vendor')->user()->company_name }}</strong>
                @if(auth('vendor')->user()->company_logo)
                <img src="{{ asset('storage/app/public/company_logos/' . auth('vendor')->user()->company_logo) }}" alt="Company Logo" class="rounded-circle" width="45" height="45">
                @endif
            </span>
        </div> 
    </header>

    <style>
/* Hide the sidebar by default on mobile */
@media (max-width: 768px) {
    #sidebar {
        position: fixed;
        left: -250px;
        top: 0;
        width: 250px;
        height: 100%;
        background: #343a40;
        transition: left 0.3s ease-in-out;
        z-index: 1000;
        padding-top: 50px;
    }

    #sidebar.show {
        left: 0;
    }

    /* Close button style */
    .close-btn {
        display: block;
        position: absolute;
        top: 10px;
        right: 10px;
        background:rgb(168, 130, 250);
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 18px;
    }

    /* Open button for mobile */
    .open-btn {
        display: block;
        position: fixed;
        top: 10px;
        left: 10px;
        background:rgb(168, 130, 250);
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        font-size: 16px;
        z-index: 1100;
        border-radius:7px;
    }

    /* Hide open button when sidebar is open */
    .open-btn.hide {
        display: none;
    }
}

/* Ensure sidebar is always visible on larger screens */
@media (min-width: 769px) {
    #sidebar {
        left: 0;
        position: relative;
    }

    .close-btn,
    .open-btn {
        display: none;
    }
}

.disabled-link {
    pointer-events: none;
    color: #adb5bd !important;  /* Lighter grey than default text-muted */
    opacity: 0.6;
}

</style>

<!-- Open Button (Only for Mobile) -->
<button id="openSidebarBtn" class="open-btn" onclick="openSidebar()">☰</button>

@php
    use Carbon\Carbon;
    use App\Models\VendorRegister;
    use App\Models\Subscription;

    // Fetch vendor from the correct guard
    $vendor = auth('vendor')->user(); 

    // Ensure vendor exists
    $memberId = $vendor->member_id ?? null;

    // Fetch Vendor Data
    $vendorData = VendorRegister::where('member_id', $memberId)->first();

    // Fetch Subscription Data
    $subscription = Subscription::where('member_id', $memberId)
                                ->where('plan_type', 'marketplace')
                                ->where('payment_status', 1)
                                ->first();

    $currentDate = Carbon::now();

    // Ensure Vendor Data Exists
    $freeTrialStart = $vendorData->free_trial_start_date ?? null;
    $freeTrialEnd = $vendorData->free_trial_end_date ?? null;
    $isTrialActive = $freeTrialStart && $freeTrialEnd && $currentDate->between($freeTrialStart, $freeTrialEnd);
    $isTrialEnded = $freeTrialEnd && $currentDate->greaterThan($freeTrialEnd);

    // Ensure Subscription Data Exists
    $subscriptionEndDate = $subscription->end_date ?? null;
    $isSubscriptionActive = $subscriptionEndDate && $currentDate->lessThanOrEqualTo($subscriptionEndDate);

    // Final Access Check
    $canAccess = $isTrialActive || $isSubscriptionActive;

    // Debugging Output
 
@endphp




<div class="row">
    <!-- Sidebar -->
    <nav id="sidebar" class="col-md-2 bg-dark p-3">
        <!-- Close Button (Mobile Only) -->
        <button class="close-btn" onclick="closeSidebar()">X</button>

        <ul class="nav flex-column">
    <li>
        <a href="{{ route('vendorlogin.auth.dashboard') }}" class="text-white">
            <i class="bi bi-person-fill"></i> Profile
        </a>
    </li>

    <li>
    <a href="{{ $canAccess ? route('vendor.products.create') : '#' }}"
       class="nav-link {{ $canAccess ? 'text-white' : 'text-muted disabled-link' }}"
       style="{{ !$canAccess ? 'pointer-events: none;' : '' }}">
       <i class="fas fa-plus-square"></i> Create Product/Services
    </a>
</li>


    <li>
        <a href="{{ $canAccess ? route('vendor-product') : '#' }}"
           class="nav-link {{ $canAccess ? 'text-white' : 'text-muted disabled-link' }}"
           style="{{ !$canAccess ? 'pointer-events: none;' : '' }}">
           <i class="fas fa-cube"></i> Manage Products /Services
        </a>
    </li>

    <li>
        <a href="{{ route('customer.support.view') }}" class="text-white">
            <i class="fas fa-plus-square"></i> Customer Support
        </a>
    </li>



        <ul class="nav flex-column">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white logout">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>

    <!-- Main Content -->
    <main role="main" id="main-content" class="col-md-10 ms-sm-auto col-lg-10 px-4">
        <div class="container mt-5">
            @yield('content1')
        </div>
    </main>
</div>



<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('show');
    document.getElementById('openSidebarBtn').classList.add('hide'); // Hide the toggle button
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('openSidebarBtn').classList.remove('hide'); // Show the toggle button
}
</script>

</div>


<script>
    // Sidebar Toggle
    $(document).ready(function () {
        $("#toggleSidebar").click(function () {
            $("#sidebar").toggleClass("active");
        });
    });
</script>




    
    <footer class="footer">
    <div class="d-flex justify-content-center align-items-center flex-column flex-sm-row text-black">
        <span class="text-center mb-1 mb-sm-0">&copy; 2025. All rights reserved.</span>
        <span class="text-center ms-sm-3">Powered by Accelerated Development Machines</span>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        // Initialize Bootstrap Tooltip with custom delay
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip({
                delay: {
                    "show": 500,
                    "hide": 100
                } // Set delay for tooltip (500ms to show, 100ms to hide)
            });
        });

        // Function to toggle submenu visibility
        function toggleSubmenu(menuId) {
            const menu = document.getElementById(menuId);
            const parentItem = menu.closest('.nav-item');
            const isActive = parentItem.classList.contains('active');

            if (isActive) {
                parentItem.classList.remove('active');
                menu.style.display = 'none'; // Hide the submenu
            } else {
                parentItem.classList.add('active');
                menu.style.display = 'block'; // Show the submenu
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Highlight the active nav item based on current URL
            var currentUrl = window.location.href;

            $(".nav-link").each(function() {
                if (this.href === currentUrl) {
                    $(this).addClass("active");
                }
            });

            // Handle nav item click to highlight the active link
            $(".nav-link").on("click", function() {
                $(".nav-link").removeClass("active"); // Remove active class from all
                $(this).addClass("active"); // Add active class to the clicked item
            });
        });
    </script>

</body>

</html>