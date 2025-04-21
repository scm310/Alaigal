<!doctype html>
<html lang="en">
<head>
    <title>Member Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ isset($gf) ? asset('storage/app/public/favicon/' . $gf->logo) : '' }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/memberlayout/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <style>
        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
        .disabled-link {
            pointer-events: none;
            color: #ccc !important;
        }
        .welcome-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-img img {
            border-radius:10px;
            margin-left:45px;
        }
        #sidebar {
            width: 250px;
            transition: all 0.3s;
        }
        #sidebar.active {
            width: 0;
        }
        .custom-menu button.active {
            background-color: #ccc;
        }
        .header1{
            margin-left:-20px;
            text-align:center;
        }
        @media (min-width: 1200px) {
            .container {
                max-width: 1280px;
            }
        }
    
/* General active menu highlighting */
.list-unstyled li.active > a {
    background-color: #007bff; /* Active color */
    color: #fff !important;
    font-weight: bold !important;
}

/* Ensure the active dropdown stays open */
.list-unstyled li.active .collapse {
    display: block !important;
}

/* Highlight active dropdown menu */
.list-unstyled .collapse.show {
    display: block !important;
}

/* Highlight active dropdown item */
.list-unstyled .collapse li.active > a {
    background-color: #0056b3; /* Slightly darker shade */
    color: #fff !important;
    font-weight: bold !important;
}

/* Ensure the parent menu of an active dropdown is bold */
.list-unstyled li.active > a,
.list-unstyled li.active > a[data-toggle="collapse"] {
    font-weight: bold !important;
}

/* Ensure normal active menu items (not dropdowns) are bold */
.list-unstyled > li.active > a {
    font-weight: bold !important;
}





        .title-text {
            color: white; 
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .title-text {
                color: white !important; 
            }
        }



        
    </style>


</head>

<body>
@php
    use Carbon\Carbon;
    use App\Models\Subscription;
    use App\Models\CustomNotification;

    $member = Auth::guard('member')->user();

    $firstName = $member ? $member->first_name : 'User';
    $profileImage = $member && $member->profile_photo 
        ? asset('storage/profile_photos/' . $member->profile_photo) 
        : asset('assets/images/default.jpg');

    $profileUpdateStatus = $member ? (int) $member->profile_update : 0;
    $paymentStatus = $member ? (int) $member->payment : 0;

    $hasSubscription = $member ? Subscription::where('member_id', $member->id)->exists() : false;
    $latestSubscription = $member ? Subscription::where('member_id', $member->id)->latest()->first() : null;

    $areMenusEnabled = $member && ($profileUpdateStatus === 1) && ($paymentStatus === 1);
@endphp

@php
    $subscriptionEndBanner = null;
    if ($latestSubscription && $latestSubscription->end_date) {
        $subEndDate = Carbon::parse($latestSubscription->end_date);
        $subDay = Carbon::now()->diffInDays($subEndDate, false);
        if ($subDay <= 5 && $subDay >= 0) {
            $subscriptionEndBanner = $subDay == 0
                ? 'Your subscription has expired. Please renew to regain access.'
                : "Your subscription ends in {$subDay} day(s) on {$subEndDate->toDateString()}.";
        }
    }
@endphp

@if($subscriptionEndBanner)
<div class="container-fluid bg-warning text-dark text-center py-2" style="font-weight:bold; font-size: 14px;">
    <div>{{ $subscriptionEndBanner }}</div>
</div>
@endif

@php
    // Disable menu if subscription has expired
    if ($latestSubscription && Carbon::parse($latestSubscription->end_date)->isToday()) {
        $areMenusEnabled = false;
    }
@endphp




<div class="wrapper d-flex align-items-stretch" style="min-height: 100vh; height: auto;">
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary d-block d-sm-none">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>

        <div class="p-4 pt-5">
            <!-- Welcome Section -->
        <div class="profile-img">
     <img src="{{ auth('member')->user()->profile_photo 
            ? asset('storage/app/public/' . auth('member')->user()->profile_photo) 
            : asset('assets/images/default.jpg') }}" 
   width="80" 
     height="80">
                </div>
                <h4 class="header1" style="font-size: 18px;">Welcome </br> {{ $firstName }}!</h4>
             
                
      

            <ul class="list-unstyled components mb-5">
                <li><a href="{{ route('memberdashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Member Profile</a></li>

                <!-- ✅ Make a Payment (Always visible when payment is required) -->
            
                <!-- ✅ Enable menu items after Profile Update (on first login), but disable after trial expiry if payment is not made -->
                @if($member)
                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                        <a href="{{ route('memberlounge.member.lounge') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                            <i class="fas fa-users"></i> Member Lounge
                        </a>
                    </li>

                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                        <a href="{{ route('clients.search') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                            <i class="fas fa-briefcase"></i> Client Connect
                        </a>
                    </li>

                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                        <a href="{{ route('ask.form') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                            <i class="fas fa-question-circle"></i> My Ask
                        </a>
                    </li>
<!-- references menu start -->
<li class="{{ !$areMenusEnabled ? 'disabled' : '' }} {{ Route::is('references.*') ? 'active' : '' }}">
    <a href="{{ route('references.index') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
        <i class="fas fa-book"></i> References
    </a>
    <ul class="list-unstyled ml-3">
        <li class="{{ Route::is('references.create') ? 'active' : '' }}">
            <a href="{{ route('references.create') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                <i class="fas fa-plus-circle"></i> Raise Reference
            </a>
        </li>
        <li class="{{ Route::is('references.onbehalf') ? 'active' : '' }}">
            <a href="{{ route('references.onbehalf') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                <i class="fas fa-user-friends"></i> On Behalf of Reference
            </a>
        </li>
    </ul>
</li>
<!-- references menu end -->




<!--thanksnote menu start-->

<li class="{{ !$areMenusEnabled ? 'disabled' : '' }} {{ Route::is('thanksnote.create') || Route::is('thanksnote.report') || Route::is('thanksnote.received') ? 'active' : '' }}">
    <a href="#" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}" data-toggle="collapse" data-target="#thanksnoteDropdown">
        <i class="fas fa-sticky-note"></i> Thanksnote
    </a>
    <ul class="collapse list-unstyled" id="thanksnoteDropdown">
        <li class="{{ Route::is('thanksnote.create') ? 'active' : '' }}">
            <a href="{{ route('thanksnote.create') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                <i class="fas fa-plus-circle"></i> Raise Thanksnote
            </a>
        </li>
        <li class="{{ Route::is('thanksnote.report') ? 'active' : '' }}">
            <a href="{{ route('thanksnote.report') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                <i class="fas fa-file-alt"></i> Thanksnote Given
            </a>
        </li>
        <li class="{{ Route::is('thanksnote.received') ? 'active' : '' }}">
            <a href="{{ route('thanksnote.received') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                <i class="fas fa-inbox"></i> Thanksnote Received
            </a>
        </li>
    </ul>
</li>
    <!--thanksnote menu end-->
                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                        <a href="{{ route('update-password.form') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                            <i class="fas fa-key"></i> Update Password
                        </a>
                    </li>

                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                    <a href="{{ route('customer') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                        <i class="fas fa-headset"></i> Customer Support
                    </a>
                </li>
                @endif

                <li>
    <a href="{{ route('subscription.payment') }}">
        <i class="fas fa-credit-card"></i> Make a Payment
    </a>
</li>


                <!-- ✅ Payment History (Only show if user has past payments) -->
                @if($hasSubscription)
                    <li>
                        <a href="{{ route('subscription.history') }}">
                            <i class="fas fa-file-invoice-dollar"></i> Payment History
                        </a>
                    </li>
                @endif


                <!-- ✅ Logout Button -->
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-block">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('memberlogout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

 <!-- Page Content -->
<div class="container py-3">
<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center text-center text-md-start">
    <!-- Logo Column -->
    <div class="mb-2 mb-md-0 me-md-4"> <!-- increased from me-md-3 to me-md-4 -->
        <img src="{{ asset('assets/images/favicon.jpeg') }}" alt="Logo" class="img-fluid" style="height: 50px; width:50px; margin-right:10px;">
    </div>

    <!-- Text Column -->
    <div>
        <h5 class="title-text m-0">TamilNadu Interior Exterior Product Merchant Directory</h5>
        <h5 class="title-text m-0">Member Portal</h5>
    </div>
</div>





    @yield('content')
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");

        // Restore scroll position after reload
        if (localStorage.getItem("sidebarScroll")) {
            sidebar.scrollTop = localStorage.getItem("sidebarScroll");
        }

        // Save scroll position before navigating
        window.addEventListener("beforeunload", function () {
            localStorage.setItem("sidebarScroll", sidebar.scrollTop);
        });
    });
</script>



<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>


</body>
</html>
