@extends('admin.layout.sidenavbar')

@section('content')


<style>

    .member-card.active {
        border:5px solid rgb(230, 145, 109) ;
        background-color: #f0f8ff;
        box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);
        transition: all 0.3s ease-in-out; /* Smooth transition */
    }





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


    .prime{
        transform: translateY(4px);
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
/* Move the search bar when the sidebar is open */
.search-container.sidebar-open {
    transform: translateX(-126px); /* Adjust the value as needed */
    transition: transform 0.3s ease-in-out; /* Smooth transition */
}

/* Reset position when the sidebar is closed */
.search-container.sidebar-close {
    transform: translateX(0px) !important;
    transition: transform 0.3s ease-in-out;
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
                margin-top:55px !important;
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
<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header">Member Lounge</div>


    <!-- Search Bar -->
<form method="GET" action="{{ route('admin.member.lounge') }}" class="search-container d-flex">
    <input type="text" name="search" class="form-control" placeholder="Search by Name, Company, or Phone" value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;

</form>

    @if ($members->isEmpty())
        <p class="text-center text-black mt-4">No search results found.</p>
    @else
<!-- Member List -->
<div class="member-list">
    @foreach($members as $member)
    <div class="card member-card shadow-sm"
     id="memberCard-{{ $member->id }}"
     onclick="openProfile({{ $member->id }})"
     style="position: relative;">
            @php
                $profilePhoto = $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.jpg');
            @endphp
            <img src="{{ $profilePhoto }}" class="passport-photo" alt="Member Photo">
            <div class="card-body p-1">
                <h6 class="member-info" title="{{ $member->last_name }}"
                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <strong>{{ $member->first_name }} {{ Str::limit($member->last_name, 3, '...') }}</strong>
                </h6>

                                    <p class="member-info company-name" title="{{ $member->company_name }}" style="margin-bottom: 2px;">
                        {{ Str::limit($member->company_name, 20, '...') }}
                    </p>
                <div class="contact-icons">
                    <i class="fas fa-phone"></i> <span>{{ $member->phone_number }}</span>
                </div>


         <!-- Prime Member Checkbox at Bottom-Right -->
<div class="checkbox-container" style="margin-top:19px;">
    <label for="prime_member">Prime Member</label>
    <input type="checkbox" class="toggle-prime-checkbox prime"
       data-id="{{ $member->id }}"
       {{ $member->prime_member ? 'checked' : '' }}
       onclick="event.stopPropagation();"
       onchange="togglePrimeMember({{ $member->id }}, this.checked)"
       {{ $member->profile_update ? '' : 'disabled' }}>


</div>


            </div>
        </div>
    @endforeach
</div>


        <!-- Profile Sidebar -->
        <div class="profile-sidebar" id="profileSidebar">
            <button class="close-btn" onclick="closeProfile()">X</button>
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
    function openProfile(memberId) {
        // 1. Remove .selected from any previously selected card
        document.querySelectorAll('.member-card.selected').forEach(card => {
            card.classList.remove('selected');
        });

        // 2. Add .selected to the clicked card
        const clickedCard = document.getElementById('memberCard-' + memberId);
        if (clickedCard) {
            clickedCard.classList.add('selected');
        }

        // 3. Fetch the profile data
        fetch(`/admin/member-profile/${memberId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Profile data could not be loaded.");
            }
            return response.text();
        })
        .then(data => {
            const profileContent = document.getElementById("profileContent");
            if (profileContent) {
                profileContent.innerHTML = data;
            }

            document.getElementById("profileSidebar").classList.add("active");
            document.querySelector(".container-wrapper").classList.add("sidebar-active");

            // Ensure search container transitions correctly
            const searchContainer = document.querySelector(".search-container");
            if (searchContainer) {
                searchContainer.classList.remove("sidebar-close");
                searchContainer.classList.add("sidebar-open");
            }
        })
        .catch(error => {
            console.error("Error fetching profile data:", error);
            alert("Failed to load profile. Please try again.");
        });
    }

    function closeProfile() {
        document.getElementById("profileSidebar").classList.remove("active");
        document.querySelector(".container-wrapper").classList.remove("sidebar-active");

        // Remove the 'selected' class from any highlighted card
        document.querySelectorAll('.member-card.selected').forEach(card => {
            card.classList.remove('selected');
        });

        // Reset search container class
        const searchContainer = document.querySelector(".search-container");
        if (searchContainer) {
            searchContainer.classList.remove("sidebar-open");
            searchContainer.classList.add("sidebar-close");
        }
    }
</script>

    
 <script>
    
    function togglePrimeMember(memberId, isChecked) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error("CSRF token not found.");
            return;
        }
    
        fetch(`/admin/toggle-prime/${memberId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken.getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ prime_member: isChecked ? 1 : 0 })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert("Error updating member status.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
    
    </script>
    
@endsection
