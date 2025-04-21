<!doctype html>
<html lang="en">
<head>
    <title>Member Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('assets/images/logo.jpeg')}}" type="image/x-icon">
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
            border-radius: 50%;
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
        @media (min-width: 1200px) {
            .container {
                max-width: 1280px;
            }
        }
    </style>
</head>

<body>
@php
    use Carbon\Carbon;

    $member = Auth::guard('member')->user();  

    $firstName = $member ? $member->first_name : 'User';
    $profileImage = $member && $member->profile_photo 
        ? asset('storage/profile_photos/' . $member->profile_photo) 
        : asset('storage/default-profile.png');

    $profileUpdateStatus = $member ? (int) $member->profile_update : 0;
    $paymentStatus = $member ? (int) $member->payment : 0;
    $freeTrialStart = $member && $member->free_trial_start_date ? Carbon::parse($member->free_trial_start_date) : null;
    $freeTrialEnd = $member && $member->free_trial_end_date ? Carbon::parse($member->free_trial_end_date) : null;

    // ✅ Trial period logic
    $isTrialActive = $freeTrialEnd && Carbon::now()->lessThanOrEqualTo($freeTrialEnd);
    $isTrialExpired = $freeTrialEnd && Carbon::now()->greaterThan($freeTrialEnd);

    // ✅ Corrected: Use 'member_id' instead of 'user_id'
    $hasSubscription = $member ? \App\Models\Subscription::where('member_id', $member->id)->exists() : false;

    // ✅ Enable menus after profile update (on first login)
    // ✅ Disable menus only after trial end & if payment is not made
    $areMenusEnabled = $member && ($profileUpdateStatus === 1) && (!$isTrialExpired || $paymentStatus === 1);
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
            <div class="welcome-section d-flex align-items-center mb-4">
                <div class="profile-img">
                    <img src="{{ $profileImage }}" class="rounded-circle" width="80" height="80">
                </div>
                <h4 class="ml-3" style="font-size: 18px;">Welcome, {{ $firstName }}!</h4>
            </div>

            <ul class="list-unstyled components mb-5">
                <li><a href="{{ route('memberdashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Member Profile</a></li>

                <!-- ✅ Make a Payment (Always visible when payment is required) -->
                @if($member && $paymentStatus == 0)
                    <li>
                        <a href="{{ route('subscription.payment') }}">
                            <i class="fas fa-credit-card"></i> Make a Payment
                        </a>
                    </li>
                @endif

                <!-- ✅ Payment History (Only show if user has past payments) -->
                @if($hasSubscription)
                    <li>
                        <a href="{{ route('subscription.history') }}">
                            <i class="fas fa-file-invoice-dollar"></i> Payment History
                        </a>
                    </li>
                @endif

                <!-- ✅ Enable menu items after Profile Update (on first login), but disable after trial expiry if payment is not made -->
                @if($user)
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

                    <li class="{{ !$areMenusEnabled ? 'disabled' : '' }}">
                        <a href="{{ route('update-password.form') }}" class="{{ !$areMenusEnabled ? 'disabled-link' : '' }}">
                            <i class="fas fa-key"></i> Update Password
                        </a>
                    </li>
                @endif

                <!-- ✅ Logout Button -->
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-block">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        @yield('content')
    </div>
</div>

<script>
    function refreshSession() {
        @if(Route::has('user.paymentStatus'))
        fetch("{{ route('user.paymentStatus') }}")
        .then(response => response.json())
        .then(data => {
            if (data.payment == 1 || data.profile_update == 1) {
                location.reload();  
            }
        })
        .catch(error => console.error('Error fetching payment status:', error));
        @endif
    }

    setInterval(refreshSession, 3000);
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
