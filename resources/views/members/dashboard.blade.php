@extends('memberlayout.navbar')

@section('content')


<link rel="stylesheet" href="{{ asset('assets\css\dashboard.css') }}">

<style>


    .trial-period {
    font-size: 12px;
   
    color: #ff0000; /* Customize color */
}

.notification-dropdown {
    display: none;
    position: absolute;
    right: 40px;
  
  top:-23px;
    width: 300px;
    background: white;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    z-index: 1000;
    max-height: 400px; /* Adjust height as needed */
    overflow-y: auto; /* Enables scrolling */
}


/* Mobile Responsive Fix */
@media screen and (max-width: 480px) {
    .notification-container {
        justify-content: space-between;
        width: 100%;
        margin-top: 70px;
    }

    /* Trial Period Message - Prevent Overlapping */
    .trial-period {
        width: 70%; /* Smaller on mobile */
        font-size: 12px; /* Reduce text size */
        padding: 5px;
        flex: 1;
        position: relative;
        z-index: 1; /* Ensure it stays below the navbar */
    }

    /* Push content down when navbar expands */
    .nav-expanded .trial-period {
        margin-top: 50px; /* Adjust dynamically */
    }

    

    .notification-wrapper, .login-icon {
        flex-shrink: 0;
    }
}

/* General Styling */
.notification-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding: 10px 0;
    position: relative;
    z-index: 10; /* Ensures it appears correctly */
}

/* Trial Period Container */
.trial-container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
}

/* Trial Message */
.trial-period, .trial-expired-label {
    background-color: red;
    color: white;
    padding: 8px;
    border-radius: 5px;
    text-align: center;
    font-size: 14px;
    width: auto;
    max-width: 90%;
}

/* Notification & Login Section */
.notification-container {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 15px;
}

/* Desktop View: Align Notification & User Icon to the RIGHT */
@media screen and (min-width: 768px) {
    .notification-container {
        justify-content: flex-end; /* Aligns to the RIGHT */
        padding-right: 20px; /* Adds space from the right edge */
       
    }
}

/* Mobile Responsive: Center the Notification Icons */
@media screen and (max-width: 767px) {
    .notification-container {
        justify-content: center; /* Centers icons in mobile view */
    }

    .trial-period, .trial-expired-label {
        font-size: 12px;
        padding: 5px;
        width: 80%;
        max-width: 80%;
    }
}




/* Mobile Responsive Fix */
@media screen and (max-width: 480px) {
    .trial-period, .trial-expired-label {
        font-size: 12px;
        padding: 5px;
        width: 80%;
        max-width: 80%;
                margin-top: -140px;
    }

    .notification-section{
        margin-top:10px;
    }

    .trial-container{
        margin-top:90px;
    }

    .notification-container {
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

.notification-bell{
   
    height:40px;
    width:40px;
    margin-left:360px;
}

.marketplace-text{
    margin-right:25px;
}

.notification-dropdown {
right: 40px;
    top: 50px;

}
    /* Ensure no overlap when sidebar is expanded */
    .nav-expanded .notification-section {
        margin-top: 60px;
    }
}

/* Marketplace Link */
.marketplace-link {
    text-decoration: none;
}

/* Purple Text with White Border (Text Outline) */
.marketplace-text {
    font-size: 10px;
   
    color: white; /* Purple Text */
   
    position: relative;
    display: inline-block;
    margin-right: -50px;
}

/* White Border Effect */
.marketplace-text::before {
    content: "Visit Marketplace";
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;

}

@media (max-width: 640px) { /* Applies only for mobile screens */
    .trial-container:empty {
        display: none;
    }
}

/* Responsive Grid */
.l-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Default - 4 columns */
    grid-gap: 20px;
    width: 100%;
    max-width: 1200px;
    padding: 20px;
    margin-top: 20px;
}

@media screen and (max-width: 640px) {  
    .l-container {
        margin-top:-60px;
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media screen and (max-width: 360px) {  
    .l-container {
        grid-template-columns: repeat(1, 1fr) !important;
    }
}

.b-game-card {
    min-width: 150px;  /* Prevents excessive shrinking */
    flex-grow: 1;
}

.notification-dropdown {
    background-color: White !important;
    border: none !important;
    padding: 0 !important;
}

.marketplace-container {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
}

.marketplace-link {
    display: inline-block;
    padding: 10px 15px;
   
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.shop-now-btn {
    background: none;
    border: none;
    font-size: 14px;
    cursor: pointer;
    position: relative;
}

.shop-now-btn .tooltip {
    visibility: hidden;
    background-color: black;
    color: white;
    text-align: center;
    padding: 5px 8px;
    border-radius: 5px;
    position: absolute;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s;
}

.shop-now-btn:hover .tooltip {
    visibility: visible;
    opacity: 1;
}


</style>

<!-- Notification Bell -->
<div class="notification-section">
<div class="trial-container">
 
</div>



    <div class="notification-container">
        <div class="notification-wrapper">
            <img src="{{ asset('assets/images/bell1.png') }}" 
                 class="notification-bell" 
                 onclick="toggleNotifications(event)" 
                 alt="Notifications">
            <span class="badge" id="notification-count"></span> <!-- Example count -->
        </div>

        <!-- User Icon -->
        <div class="marketplace-container" style="    margin-top: -100px;
    margin-right: 45px;">
    <a href="{{ route('home') }}" class="marketplace-link" target="_blank" rel="noopener noreferrer">
        <span class="marketplace-text">Visit Marketplace</span>
    </a>
</div>





    </div>



@php
    $seenNotifications = json_decode(request()->cookie('seen_notifications'), true) ?? [];
@endphp

@if(!empty($notifications) && count($notifications) > 0)
    <!-- Notification Dropdown -->
    <div class="notification-dropdown" id="notification-dropdown">
    <ul id="notification-list">
        @foreach($notifications as $notification)
            @if(!in_array($notification->id, $seenNotifications))  {{-- Ignore seen notifications --}}
                <li id="notification-{{ $notification->id }}" class="notification-item">
                    @if($notification->type === 'product')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->member_name, 'open_profile' => $notification->id, 'tab' => 'products']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>{{ $notification->member_name }} added a new product: {{ $notification->product_name }}</span>
                        </a>
                    @elseif($notification->type === 'service')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->user_name, 'open_profile' => $notification->id, 'tab' => 'services']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>{{ $notification->user_name }} added a new service: {{ $notification->service_name }}</span>
                        </a>
                    @elseif($notification->type === 'testimonial')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->user_name, 'open_profile' => $notification->id, 'tab' => 'testimonials']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>{{ $notification->client_name }} gave a testimonial to {{ $notification->user_name }}</span>
                        </a>
                    @elseif($notification->type === 'client')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->user_name, 'open_profile' => $notification->id, 'tab' => 'clients']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>New client added: {{ $notification->client_name }} from {{ $notification->company_name }}</span>
                        </a>
                    @elseif($notification->type === 'new_member')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->first_name, 'open_profile' => $notification->id, 'tab' => 'profile']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>New member joined: {{ $notification->first_name }} {{ $notification->last_name }}</span>
                        </a>
                    @elseif($notification->type === 'completed_project')
                        <a href="{{ route('memberlounge.member.lounge', ['search' => $notification->user_name, 'open_profile' => $notification->id, 'tab' => 'projects']) }}" 
                           onclick="markNotificationAsRead({{ $notification->id }})">
                            <span>Project completed: {{ $notification->project_name }} for client {{ $notification->client_name }} at {{ $notification->company_name }}</span>
                        </a>
                        @elseif($notification->type === 'hot_selling')
    <a href="{{ route('home') }}" onclick="markNotificationAsRead({{ $notification->id }})">
        <span>{{ $notification->seller_name }}'s product <b>{{ $notification->item_name }}</b> is now a Hot Selling Product!</span>
    </a>
    <a href="{{ route('home') }}" target="_blank">
        <button class="shop-now-btn">
            🛒
            <span class="tooltip">Shop Now</span>
        </button>
    </a>
@endif



                    <button class="remove-notification" onclick="removeNotification({{ $notification->id }})">X</button>
                </li>
            @endif
        @endforeach
    </ul>
</div>

@endif




</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let removedNotifications = JSON.parse(localStorage.getItem('removedNotifications')) || [];
        let clickedNotifications = JSON.parse(localStorage.getItem('clickedNotifications')) || [];

        let notifications = document.querySelectorAll('.notification-item');
        notifications.forEach(notification => {
            let notificationId = parseInt(notification.id.replace('notification-', ''));
            if (removedNotifications.includes(notificationId) || clickedNotifications.includes(notificationId)) {
                notification.remove(); // Remove if already removed or clicked
            }
        });

        updateNotificationCount();
    });

    // 1️⃣ Toggle Notification Dropdown
    function toggleNotifications(event) {
        event.stopPropagation();
        let dropdown = document.getElementById('notification-dropdown');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    }

    // 2️⃣ Remove Notification Manually
    function removeNotification(notificationId) {
        let notificationElement = document.getElementById('notification-' + notificationId);
        if (notificationElement) {
            notificationElement.remove();

            let removedNotifications = JSON.parse(localStorage.getItem('removedNotifications')) || [];
            if (!removedNotifications.includes(notificationId)) {
                removedNotifications.push(notificationId);
                localStorage.setItem('removedNotifications', JSON.stringify(removedNotifications));
            }

            updateNotificationCount();
        }
    }

    // 3️⃣ Mark Notification as Read (Hide on Click)
    function markNotificationAsRead(notificationId) {
        let clickedNotifications = JSON.parse(localStorage.getItem('clickedNotifications')) || [];
        
        if (!clickedNotifications.includes(notificationId)) {
            clickedNotifications.push(notificationId);
            localStorage.setItem('clickedNotifications', JSON.stringify(clickedNotifications));
        }

        let notificationElement = document.getElementById('notification-' + notificationId);
        if (notificationElement) {
            notificationElement.remove();
        }

        updateNotificationCount();
    }

    // 4️⃣ Update Notification Count
    function updateNotificationCount() {
        let notifications = document.querySelectorAll('.notification-item');
        let removedNotifications = JSON.parse(localStorage.getItem('removedNotifications')) || [];
        let clickedNotifications = JSON.parse(localStorage.getItem('clickedNotifications')) || [];

        let visibleNotifications = Array.from(notifications).filter(notification => {
            let notificationId = parseInt(notification.id.replace('notification-', ''));
            return !removedNotifications.includes(notificationId) && !clickedNotifications.includes(notificationId);
        });

        let countElement = document.getElementById('notification-count');
        let count = visibleNotifications.length;

        countElement.innerText = count;
        countElement.style.display = count > 0 ? 'inline' : 'none';
    }

    // 5️⃣ Automatically Open Profile Based on Notification
    function openProfileAutomatically(memberName) {
        setTimeout(function () {
            let searchField = document.querySelector('input[name="search"]');
            if (searchField) {
                searchField.value = memberName;
                document.querySelector('form.search-container').submit();
            }

            setTimeout(function () {
                let memberCards = document.querySelectorAll('.member-card');
                memberCards.forEach(card => {
                    if (card.innerText.includes(memberName)) {
                        card.click();
                    }
                });
            }, 1500);
        }, 500);
    }

    // 6️⃣ Hide Dropdown When Clicking Outside
    document.addEventListener("click", function (event) {
        let dropdown = document.getElementById('notification-dropdown');
        let bellIcon = document.querySelector('.notification-bell');

        if (!dropdown.contains(event.target) && !bellIcon.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>








<!-- Cards -->
<div class="l-container grid grid-cols-2 gap-4 md:grid-cols-4">
    <div class="b-game-card">
        <div class="b-game-card__cover">
            <div class="content">
                <i class="fas fa-users fa-2x mb-2" style="color: white;"></i>
                <h2>{{ $memberCount }}</h2>
                <p>Members</p>
            </div>
        </div>
    </div>

    <div class="b-game-card">
        <div class="b-game-card__cover">
            <div class="content">
                <i class="fas fa-briefcase fa-2x mb-2" style="color: white;"></i>
                <h2>{{ $clientCount }}</h2>
                <p>Clients</p>
            </div>
        </div>
    </div>

    <div class="b-game-card">
        <div class="b-game-card__cover">
            <div class="content">
                <i class="fas fa-box fa-2x mb-2" style="color: white;"></i>
                <h2>{{ $productCount }}</h2>
                <p>Products</p>
            </div>
        </div>
    </div>

    <div class="b-game-card">
        <div class="b-game-card__cover">
            <div class="content">
                <i class="fas fa-cogs fa-2x mb-2" style="color: white;"></i>
                <h2>{{ $serviceCount }}</h2>
                <p>Services</p>
            </div>
        </div>
    </div>
</div>




<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
