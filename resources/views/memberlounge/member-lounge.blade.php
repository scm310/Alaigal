<!-- Author:ADM
Description:Member Lounge Page
Date:31/01/2025
Updated on:18/02/2025-->

@extends('memberlayout.navbar')
<style>
    /* hellow */
.prime-ribbon {
    position: absolute;
    top: 10px;
    right: -10px;
    background: gold;
    color: black;  
    font-weight: bold;
    padding: 5px 20px;
    font-size: 14px;
    transform: rotate(45deg);
    transform-origin: top right;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}



    /* Remove space above header */
    /* body {
        margin: 0;
        padding: 0;
        background: url('{{ asset("images/background.jpg") }}') no-repeat center center fixed;
        background-size: cover;
    } */

    /* Main Container */
    .container-wrapper {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
        overflow: hidden;
    }

    /* Header */
    .header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    /* Search Bar */
    .search-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease-in-out;
}

/* Move the search bar slightly when the sidebar is open */
.search-container.sidebar-open {
    transform: translateX(-90px); /* Adjust the value as needed */
}


    .search-container input {
        width: 270px;
        height: 35px;
        margin-right: 5px;
        background-color:#CBC3E3;
   
    }

    .search-container button {
        height: 35px;
       
    }

    /* Member List */
    .member-list {
        display: grid;
        grid-template-columns: repeat(6, 1fr);

        gap: 10px;
        padding: 10px 0;
        transition: grid-template-columns 0.3s ease-in-out;
    }

   /* Adjust grid when profile sidebar opens */
    .container-wrapper.sidebar-active {
        width: 70%;
    }

    .container-wrapper.sidebar-active .member-list {
        grid-template-columns: repeat(4, 1fr);
    }

      /* Member Card Styling */
    .member-card {
        width: 100%;
        max-width: 180px;
        height: 230px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: transform 0.2s ease-in-out, box-shadow 0.3s ease-in-out;
        background: linear-gradient(to right, #b993d6, #8ca6db);
        color: white;
        text-align: center;
        cursor: pointer;
        font-size: 11px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Hover effect */
    .member-card:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .member-card.selected {
    border: 5px solid rgb(230, 145, 109) ;
    background-color: #f8f9fa;  /* Light background */
    transition: all 0.s ease;  /* Smooth transition */
}



    /* Tooltip */
    .member-card::after {
        width:140px;
    content: "Click to View Profile";
    visibility: hidden;
    opacity: 0;
    background: linear-gradient(to right, #ffe259, #ffa751);
    color: white;
    text-align: center;
    border-radius: 4px;
    padding: 5px;
    position: absolute; /* Change from fixed to absolute */
    top: -30px; /* Move below the card */
    left: 50%; /* Center horizontally */
    transform: translateX(-50%); /* Ensure it is properly centered */
    font-size: 10px;
    transition: opacity 0.3s ease-in-out;
    pointer-events: none;
    z-index: 10; /* Keep above other elements */
}

/* Highlight the active member card */
.member-card.active {
    border:5px solid rgb(230, 145, 109) ;
    background-color: #f0f8ff;
    box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);
    transition: all 0.3s ease-in-out; /* Smooth transition */
    ``
}

/* Optional: Auto-highlight based on sidebar visibility */
.container-wrapper.sidebar-active .member-card:has(+ #profileSidebar.active) {
    border: 2px solid #28a745 !important; /* Green highlight */
}

    .member-card:hover::after {
        visibility: visible;
        opacity: 1;
    }

    /* Passport Photo */
    .passport-photo {
        width: 100%;
        height: 110px; /* Increased height to prevent image cutoff */
        object-fit: fill;
        border-radius: 8px;
    }
/* Ensure company name wraps inside the card */
    .member-info.company-name {
        white-space: normal; /* Allows text to wrap */
        overflow-wrap: break-word; /* Breaks long words */
        text-align: center;
        font-size: 10px; /* Slightly smaller for better fit */
        max-width: 100%; /* Prevents overflow */
        line-height: 1.2; /* Improves readability */
    }

    /* Phone & Email Icons */
    .contact-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap:3px;
        font-size:8px;
    }

    .contact-icons i {
        color: white;
    }


.profile-sidebar {
    width: 530px;
    background: linear-gradient(to right, #1d2b64, #f8cdda);
    position: fixed;
    right: 0;
    top: 90px; /* Adjust if necessary */
    height: calc(100% - 90px); /* Prevents it from overlapping the search bar */
    overflow-y: auto;
    box-shadow: -5px 0px 10px rgba(0, 0, 0, 0.2);
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
    padding: 20px;
    border-radius: 10px;
    z-index: 999; /* Keep it below the search bar */
}


/* Ensure sidebar is visible when active */
.profile-sidebar.active {
    transform: translateX(0);
}

/* Adjust main container when sidebar is open */
.container-wrapper.sidebar-active {
    width: 75%;
    margin-left:-1px; /* Move slightly left */
}


   /* Small Close Button */
   .close-btn {
    margin-left: 465px;
    margin-top: -24px;
    background: transparent;
    color: #b993d6;
    font-size: 17px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    z-index: -1 !important;
}

.close-btn:hover {
    color: red;
}
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 10px 0;
    }

    .pagination a,
    .pagination span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        background: white;
        text-decoration: none;
        border-radius: 5px;
        color: black;
    }

    .pagination a:hover,
    .pagination .active span {
        background: #b993d6;
        color: white;
        font-weight: bold;
    }

    .member-info{
        font-size:12px;
    }


    .container-wrapper{
            margin-top:20px !important;
        }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-wrapper.sidebar-active {
            width: 100%;
        }

        .container-wrapper.sidebar-active .member-list {
            grid-template-columns: repeat(2, 1fr);
        }
        .container-wrapper{
            margin-top:10px !important;
        }

        .member-list {
            grid-template-columns: repeat(2, 1fr);
            width: 335px;
            margin-left:-10px;
            font-size: 11px;
        }

        .profile-sidebar {
            width: 100%;
        }

        .card-body{
            font-size: 11px;
        }
        .contact-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap:3px;
        font-size:8px;
    }

    .search-container input {
        width: 200px;
        height: 35px;
        margin-right: 5px;
        background-color:#CBC3E3;
    }

    .profile-sidebar.active {
        transform: translateX(-2px);
        width: 370px;
        border-radius: 10px;
    }


    .close-btn {
    margin-left: 296px;
    margin-top: -16px;
    background: transparent;
    color: #b993d6;
    font-size: 17px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    z-index: -1 !important;
    padding:14px;
}


    }

    .box {
   width:200px;height:300px;
   position:relative;
   border:1px solid #BBB;
   background:#eee;
   float:left;
   margin:20px
}
.ribbon {
   position: absolute;
   right: -5px; top: -5px;
   z-index: 1;
   overflow: hidden;
   width: 75px; height: 75px;
   text-align: right;
}
.ribbon span {
   font-size: 10px;
   color: #fff;
   text-transform: capitalize;
   text-align: center;
   font-weight: bold; line-height: 20px;
   transform: rotate(45deg);
   width: 100px; display: block;
   background: #79A70A;
   background: linear-gradient(#9BC90D 0%, #79A70A 100%);
   box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
   position: absolute;
   top: 19px; right: -21px;
}
.ribbon span::before {
   content: '';
   position: absolute;
   left: 0px; top: 100%;
   z-index: -1;
   border-left: 3px solid #79A70A;
   border-right: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}
.ribbon span::after {
   content: '';
   position: absolute;
   right: 0%; top: 100%;
   z-index: -1;
   border-right: 3px solid #79A70A;
   border-left: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}
.red span {
    background: radial-gradient(ellipse farthest-corner at right bottom, #FEDB37 0%,rgb(255, 197, 80) 8%,rgb(231, 177, 62) 30%,rgb(255, 195, 55) 40%, transparent 80%),
    radial-gradient(ellipse farthest-corner at left top, #FFFFFF 0%, #FFFFAC 8%,rgb(255, 207, 75) 25%,rgb(247, 193, 68) 62.5%,rgb(255, 200, 73) 100%);
}
.red span::before {border-left-color: #ffd22f; border-top-color: #ffd22f;}
.red span::after {border-right-color: #ffd22f; border-top-color: #ffd22f;}

.form-control:focus{
    background:rgb(218, 209, 227) !important;
}


</style>
<!-- CSS to Enlarge Icon -->
<style>
.mp-button {
    background-color: transparent; /* Transparent background */
    border: 1px solid #FFFFFF; /* Black border */
    color: #fff; /* Text color */
    padding: 2px 8px; /* Reduced padding to make border fit closely */
    font-size: 18px; /* Increased font size */
    font-weight: bold; /* Bold text */
    cursor: pointer;
    border-radius: 5px; /* Slightly rounded corners */
    transition: all 0.3s ease;
    line-height: 1; /* Ensures proper alignment */
}

.mp-button:hover {
    background-color:rgb(203, 160, 229); /* Light gray background on hover */
}



</style>
@section('content')

    <div class="container-wrapper mt-3">
        <!-- Header -->
        <div class="header">Member Lounge</div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('memberlounge.member.lounge') }}" class="search-container d-flex">
        <input type="text" name="search" class="form-control" placeholder="Search by Name, Company, or Phone" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;

    </form>


        @if ($members->isEmpty())
            <p class="text-center text-black mt-4">No search results found.</p>
        @else


<!-- Member List -->
<div class="member-list">
    @foreach($members as $member)
        @php
            // Fetch subscription data for the member
            $subscription = DB::table('subscriptions')
                ->where('member_id', $member->id)
                ->where('plan_type', 'marketplace')
                ->where('payment_status', 1)
                ->first();

            // Get profile photo or default
            $profilePhoto = $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('/assets/images/default.jpg');
        @endphp

    <div class="card member-card shadow-sm" data-member-id="{{ $member->id }}" onclick="openProfile({{ $member->id }}, this)" style="display: flex; flex-direction: column; justify-content: space-between; height: 95%;">

        @if($member->prime_member == 1)
            <div class="ribbon red"><span class="text-dark">Prime</span></div>
        @endif

        <img src="{{ $profilePhoto }}" class="passport-photo" alt="Member Photo">

        <div class="card-body p-1" style="flex-grow: 1;">
            <h6 class="member-info" title="{{ $member->first_name }} {{ $member->last_name }}" 
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <strong>{{ Str::limit($member->first_name . ' ' . $member->last_name, 15, '...') }}</strong>
            </h6>

            <p class="member-info company-name" title="{{ $member->company_name }}" style="margin-bottom: 2px;">
                {{ Str::limit($member->company_name, 20, '...') }}
            </p>

            <div class="contact-icons" style="margin-top: 2px; display: flex; align-items: center;">
                <i class="fas fa-phone"></i> <span>{{ $member->phone_number }}</span>
            </div>
            <br>
        </div>

        @if($subscription)
        <div class="mp-button-container" style="display: flex; justify-content: center; margin-top: -10px;">
            <a href="{{ route('member.products', ['member_id' => $member->id]) }}" 
               class="mp-button" 
               title="View Products/Services in Marketplace" 
               target="_blank" 
               rel="noopener noreferrer" 
               style="
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    width: 50px; 
                    height: 50px; 
                    border: none; 
                    cursor: pointer;
                    font-size: 18px;
                    background: none; 
                    color: #fff;">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
        @endif
    </div>
    @endforeach
</div>






            <!-- Profile Sidebar -->
            <div class="profile-sidebar" id="profileSidebar">

                    <button class="close-btn" onclick="closeProfileAndRedirect()">X</button>

                <div id="profileContent">



                    <!-- Profile details will be dynamically loaded here -->
                </div>
            </div>

            <!-- Pagination Links -->
            <div class="pagination d-flex justify-content-center mt-4">
        {{ $members->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
    </div>
        @endif
    </div>

<script>

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const memberId = urlParams.get("open_profile"); // Get member ID from URL
    const tab = urlParams.get("tab"); // Get tab name from URL

    if (memberId) {
        openProfile(memberId, tab); // Open profile immediately
    }
});

function openProfile(memberId) {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab'); // Get tab from URL

    fetch(`/member-profile/${memberId}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("profileContent").innerHTML = data;
            document.getElementById("profileSidebar").classList.add("active");
            document.querySelector(".container-wrapper").classList.add("sidebar-active");
            document.querySelector(".search-container").classList.add("sidebar-open");

            // Remove 'active' class from all member cards
            document.querySelectorAll(".member-card").forEach(card => {
                card.classList.remove("active");
            });

            // Select the correct member card using data-member-id
            const selectedCard = document.querySelector(`.member-card[data-member-id="${memberId}"]`);
            if (selectedCard) {
                selectedCard.classList.add("active");
            }

            // Ensure the correct tab is selected AFTER profile is loaded
            if (tab) {
                let targetTab = document.querySelector(`a[href="#${tab}"]`);
                let targetContent = document.getElementById(tab);

                if (targetTab && targetContent) {
                    document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
                    document.querySelectorAll(".tab-pane").forEach(content => content.classList.remove("show", "active"));

                    targetTab.classList.add("active");
                    targetContent.classList.add("show", "active");

                    new bootstrap.Tab(targetTab).show();
                }
            }
        });
}


function closeProfile() {
    document.getElementById("profileSidebar").classList.remove("active");
    document.querySelector(".container-wrapper").classList.remove("sidebar-active");
    document.querySelector(".search-container").classList.remove("sidebar-open");


    // Remove highlight from all member cards
    document.querySelectorAll(".member-card").forEach(card => card.classList.remove("active"));
}

function closeProfileAndRedirect() {
    closeProfile(); // Call the existing function

    // Add a small delay to allow the sidebar to close smoothly before redirecting
    setTimeout(() => {
        window.location.href = "{{ route('memberlounge.member.lounge') }}";
    }, 300); // Adjust delay time if needed
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab'); // Get tab from URL
    const memberCards = document.querySelectorAll(".member-card"); // Get all member cards

    if (tab && memberCards.length > 0) {
        // Find the first member card and extract the ID
        let firstMember = memberCards[0];
        let memberId = firstMember.getAttribute("onclick").match(/\d+/)[0]; // Extract ID from onclick

        if (memberId) {
            openProfile(memberId); // Automatically open the first matching profile
        }
    }

    if (tab) {
        let targetTab = document.querySelector(`a[href="#${tab}"]`);
        let targetContent = document.getElementById(tab);

        if (targetTab && targetContent) {
            document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
            document.querySelectorAll(".tab-pane").forEach(content => content.classList.remove("show", "active"));

            targetTab.classList.add("active");
            targetContent.classList.add("show", "active");

            new bootstrap.Tab(targetTab).show();
        }
    }
});

</script>



@endsection
