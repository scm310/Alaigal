@extends('memberlayout.navbar')

@section('content')


<style>


.container-wrapper {
        width: 95%;
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
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


    @media (max-width: 576px) {
    .member-client-list {
        margin-top:10px;
        margin-left: 0;
    }
    }
    
</style>

<style>
    


.client-card {
    background-color: #4a3c74; /* Adjust the background color */
    color: white;

    border-radius:5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    min-height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.client-card img {
    width: 135px;
    height: 95px;  
    border-radius:5%;
    border: 2px solid #ccc;
}

.client-card h6, .client-card p {
    margin: 0;
    font-size: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;
}



.client-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.alphabet-btn {
    padding: 5px 10px;
    border-radius: 10px;
    text-decoration: none;
    color: white;
    background-color: #6a5acd;
    margin: 2px;
}

.alphabet-btn.disabled {
    opacity: 0.5;
    pointer-events: none;
}

.company-list-container {
    max-height: 350px;
    overflow-y: auto;
}

.list-group-item a {
    text-decoration: none;
    color: #4a3c74;
    font-weight: bold;
}


.alphabet-btn {
       
        background-color: white;
        color: blue;
       
       
    }

    .alphabet-btn:hover {
        background-color: white;
        color: darkblue;
        border-color: darkblue;
    }

    .disabled {
        color: gray !important;
        border-color: lightgray !important;
        pointer-events: none;
    }

    h5.text-center {
        color: white;
    }


    
@media (max-width: 768px) {
    .client-card {
        width: 100%;
        min-height: auto;
    }


}



/* General container styling */
.container-wrapper {
    max-width: 1200px;
    margin: auto;

}

/* Client list and filter container */
.client-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

/* Client Card Styling */
.client-card {
    height: 240px;
    background: linear-gradient(to right, #b993d6, #8ca6db);
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Ensuring 4 cards per row in large screens */
@media (min-width: 992px) {
    .client-list .col-md-3 {
        flex: 0 0 23%;
        max-width: 24%;
        padding-right:0px  !important;
        padding-left:0px !important;
    }
}

/* Mobile Responsive: Cards adjust to 2 per row */
@media (max-width: 991px) {
    .client-list .col-md-3 {
        flex: 0 0 48%;
        max-width: 48%;
    }
}

/* Mobile view: Cards take full width */
@media (max-width: 576px) {
    .client-list .col-md-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

/* Main Layout: 70% cards, 30% member client list */
.main-container {
    display: flex;
    gap: 20px;
}

/* Cards section taking 70% */
.cards-section {
    flex: 0 0 70%;
    max-width: 70%;
}

/* Member client list taking 30% */
/* Default styling for all screen sizes */
.member-client-list {
    top: 20px;
    position: sticky;
    z-index: 1000;
    background-color: #fff;
    width: 230px;
    margin-left: 50px;
}

/* Apply new styles only for desktop screens (min-width: 992px) */
@media (min-width: 992px) {
    .member-client-list {
        flex: 0 0 30%;
        max-width: 28%;
        position: sticky;
        top: 20px;
        z-index: 1000;
        background-color: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        width: auto;
        margin-left: 0;
        height: 450px;
        margin-top:-60px;
    }
}


.alphabet-btn {
    height:20px;
    font-size: 9px; /* Adjust the size as needed */
    padding: 2px 2px; /* Reduce padding to match the smaller font */
}

.company-list-container {
    padding: 5px; /* Reduce overall padding */
}

.list-group-item {
    padding: 4px 8px; /* Reduce inner padding */
    height: 25px; /* Reduce height */
    line-height: 25px; /* Adjust text alignment */
    font-size: 12px; /* Optional: Adjust font size */
}



/* Adjust for smaller screens */
@media (max-width: 991px) {
    .main-container {
        flex-direction: column;
    }
    .cards-section, .member-client-list {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .member-client-list {
        width: 500px !important; 
        margin-top: -20px !important;
        margin-left: 1px !important;
    }
}


@media (max-width: 768px) { 
    /* Stack elements vertically */
    .main-container {
        flex-direction: column;
    }

    /* Move Member Client List below the search bar */
    .member-client-list {
        order: 2;
        margin-top: 20px;
        margin-left:17px;
        border-radius: 10px;
        position: relative !important; /* Remove sticky effect */
        text-align: center; /* Center align content */
     
    }

    /* Ensure the search bar takes full width */

    .search-container input {
        width: 100% !important;
        margin-bottom: 10px;
    }

    .search-container button {
        width: 100%;
    }

    /* Move Cards Section below both */
    .cards-section {
        order: 3;
        width: 100%;
    }

    /* Center the alphabet filter inside Member Client List */
    .alphabet-filter {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Ensure company list is centered */
    .company-list-container {
        display: flex;
        justify-content: center;
    }

    /* Adjust Client Cards */
    .client-list .col-md-3 {
        width: 50%;
    }

    @media (max-width: 480px) { 
        .client-list  {
            width: 100%; 
        }
    }
}

</style>

<style>
    /* Ensure text wraps properly without truncation */
    .text-wrap {
        white-space: normal !important; /* Ensures text wraps */
        word-wrap: break-word; /* Breaks long words */
        overflow-wrap: break-word; /* Ensures breaking */
    }

    .text-wrap-container {
        max-width: 100%; /* Adjust container width */
        word-break: break-word; /* Ensures breaking */
    }

    .client-card {
        width: 100%;
        min-height: 120px; /* Adjust card height if needed */
    }

    h5.text-center{
        color: black;
    }

     /* Custom thin scrollbar */
     .custom-scrollbar {
        max-height: 300px; /* Adjust height if needed */
        overflow-y: auto;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 5px; /* Thinner scrollbar width */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #888; /* Color of the scrollbar */
        border-radius: 10px; /* Rounded edges */
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: #f1f1f1; /* Track background color */
    }
</style>
<style>
    @media (max-width: 576px) { /* Small screen (mobile) */
        .search-container {
            width:100% !important;
        }

        .search-container input {
            width: 60% !important;
        }
        .search-container button {
            width:30% !important;
            transform: translateY(-4px);
        }
    }

    .client-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.client-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}

</style>
<style>
/* Custom Card Styling */
.card {
    position: relative;
    width: 250px;
    height: 250px;
    background-color: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
}

/* Top Section (White) */
.top-card {
    height: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background-color: #fff;
    text-align: center;
}

/* Bottom Section (Gradient) */
.bottom-card {
    height: 50%;
    background: linear-gradient(to right, #b993d6, #8ca6db);
    color: white;
    text-align: center;
    padding: 10px;
    position: relative;
    border-top-right-radius: 10px; /* Adjust the value as needed */
}


/* Profile Image */
.profile-photo {
    width: 55px;
    height: 55px;
    object-fit: fill;
    border-radius: 50%;
    border: 2px solid #8ca6db;
}

/* Name & Contact Details */
h6 {
    font-size: 10px;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
}

p {
    font-size: 9px;
    margin: 0;
}

.view-more {
    display: block;
    width: 40%; /* Slight margin for better UI */
    position: absolute;
    bottom: 5px;
    left: 50%;
    transform: translateX(-50%);
    background-color: white;
    color: #007bff;
    font-size: 9px;
    font-weight: bold;
    padding: 6px 0;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.view-more:hover {
    background-color: #007bff;
    color: white;
}



/* Plus Icon */
.plus-icon {
    font-size: 12px;
    font-weight: bold;
    color: rgb(243, 246, 248);
    cursor: pointer;
}

/* Responsive */
@media (max-width: 768px) {
    .card {
        width: 220px;
        height: 220px;
    }
    .profile-photo {
        width: 50px;
        height: 50px;
    }
    h6 {
        font-size: 9px;
    }
    p {
        font-size: 8px;
    }
    .view-more {
        font-size: 9px; /* Reduce font size */
        padding: 2px 6px; /* Reduce padding */
    }
}
</style>

<div class="container-wrapper mt-3">
    <div class="header">Client Connect</div>

    <!-- Search Bar -->
    <div class="d-flex justify-content-center mt-4">
    <div class="search-container p-3 rounded" style="width: 50%;">
        <form action="{{ route('clients.search') }}" method="GET" class="d-flex justify-content-center align-items-center w-100 flex-nowrap"> 
            <input type="text" name="search" class="form-control" style="background-color: #CBC3E3; width: 250px;" placeholder="Search Company Name" value="{{ request('search') }}" required>&nbsp; &nbsp; &nbsp;
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>
    </div>
</div>




    <!-- Main Layout -->
    <div class="main-container mt-4">
        <!-- 70% Cards Section -->
        <div class="cards-section">
            @if(request('search'))
                @if(isset($users) && count($users) > 0)
                    <p class="text mt-1 text-center"  style="font-size: 14px;">
                        Members connected to 
                        <span style="background-color: #866ec7; color: white; padding: 2px 5px; border-radius: 5px;">
                            "{{ request('search') }}"
                        </span> 
                        - {{ count($users) }}
</p>
                    <div class="client-list row">
    @foreach($users as $user)
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 d-flex justify-content-center mt-2">
    <div class="card shadow-lg rounded-4" style="background: linear-gradient(to right, #b993d6, #8ca6db); width: 100%; max-width: 280px; height:200px; overflow: hidden; border: none; " >
        
        <!-- Top Section (White) -->
        <div class="text-center p-3" style="background: linear-gradient(to right, #b993d6, #8ca6db); color: white;">
            @php
                $profilePhoto = $user->profile_photo 
                    ? asset('storage/app/public/' . $user->profile_photo) 
                    : asset('assets/images/default.jpg');
            @endphp
            <img src="{{ $profilePhoto }}" alt="{{ $user->first_name }}" 
                 class="rounded-circle border border-secondary" 
                 style="width: 70px; height: 70px; object-fit: fill;">

            <!-- Name -->
            <h6 class="mt-2 fw-bold name-tooltip"
                style="font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;"
                title="{{ $user->first_name }} {{ $user->last_name }}"
                onclick="showTooltip(this)">
                {{ $user->first_name }} {{ $user->last_name }}
            </h6>

            <!-- Phone -->
            <p class="m-0" style="font-size: 11px;">{{ $user->phone_number }}</p>

            <!-- Email with Tooltip -->
            <p class="m-0 email-tooltip"
                style="font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;"
                title="{{ $user->email }}"
                onclick="showTooltip(this)">
                {{ $user->email }}
            </p>

            <!-- Company Name -->
            <p class="m-0" style="font-size: 12px;">
                {{ $user->company_name }}
            </p>
        </div>
    </div>
</div>
    @endforeach
</div>




                @else
                    <p class="text text-center mt-4">No results found.</p>
                @endif
            @else
            
 

<!-- Member Cards -->
<div class="row mt-1 d-flex justify-content-center">
    @foreach($alphabeticalClients as $user)
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 d-flex justify-content-center">
    @php
        $allCompanies = collect();
        if ($user->clients->isNotEmpty()) {
            $allCompanies = $allCompanies->merge($user->clients->pluck('company_name'));
        }
        if ($user->testimonials->isNotEmpty()) {
            $allCompanies = $allCompanies->merge($user->testimonials->pluck('company_name'));
        }
        if ($user->completedProjects->isNotEmpty()) {
            $allCompanies = $allCompanies->merge($user->completedProjects->pluck('company_name'));
        }
        $allCompanies = $allCompanies->unique();
        $displayCompanies = $allCompanies->take(3);
        $hiddenCompanies = $allCompanies->slice(3);
        $hasMoreCompanies = $hiddenCompanies->isNotEmpty();
    @endphp

    <div class="card">
        <!-- Top Section -->
        <div class="top-card">
            @php
                $profilePhoto = $user->profile_photo 
                    ? asset('storage/app/public/' . $user->profile_photo) 
                    : asset('assets/images/default.jpg');
            @endphp
            <img src="{{ $profilePhoto }}" alt="{{ $user->first_name }}" class="profile-photo">

            <!-- Name & Phone -->
            <h6 class="m-0 name-tooltip" 
                style="font-size: 11px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;"
                title="{{ $user->first_name }} {{ $user->last_name }}">
                {{ $user->first_name }} {{ $user->last_name }}
            </h6>

            <p class="m-0" style="font-size: 9px;">{{ $user->phone_number }}</p>
            <p class="m-0 email-tooltip" 
                style="font-size: 9px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" 
                title="{{ $user->email }}">
                {{ $user->email }}
            </p>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-card">
            <p class="m-0" style="font-size: 9px;"><strong>Connected With:</strong></p>
            <p class="m-0" style="font-size: 9px; display: inline-block;">
                {{ $displayCompanies->implode(', ') }}
            </p>
        </div>

        <!-- View More Button (Always at Bottom) -->
        @if ($hasMoreCompanies)
        <a href="{{ route('memberlounge.member.lounge', ['search' => $user->first_name, 'open_profile' => $user->id, 'tab' => 'clients']) }}" 
            class="view-more">
            View More
        </a>
        @endif
    </div>
</div>
    @endforeach
</div>







                <div class="pagination mt-4 d-flex justify-content-center">
                    {{ $alphabeticalClients->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>

        <!-- 30% Member Client List -->
        <div class="member-client-list" style="background: linear-gradient(to right, #1d2b64, #f8cdda);">
        <h5 class="text-center" style="color: white;">Member Client List</h5>

            <div class="alphabet-filter text-center">
                    <a href="#" class="alphabet-btn all-btn" data-letter="all">All</a>
                    <div class="alphabet-container">
                        @foreach(array_chunk($allLetters, 13) as $row)
                            <div class="alphabet-row">
                                @foreach($row as $letter)
                                    <a href="#" 
                                       class="alphabet-btn {{ in_array($letter, $availableLetters) ? '' : 'disabled' }}" 
                                       data-letter="{{ $letter }}"
                                       {{ in_array($letter, $availableLetters) ? '' : 'tabindex=-1' }}>
                                        {{ $letter }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Company List Container -->
                <div class="company-list-container" id="companyList">
    <ul class="list-group custom-scrollbar">
        @foreach($companies as $company)
            <li class="list-group-item company-item" data-company-name="{{ $company->company_name }}">
                <a href="{{ route('clients.search', ['search' => $company->company_name]) }}" class="company-link">
                    {{ $company->company_name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
        </div>
    </div>


    <script>
    function toggleCompanies(button) {
        let hiddenCompanies = button.nextElementSibling;
        if (hiddenCompanies.classList.contains('d-none')) {
            hiddenCompanies.classList.remove('d-none');
            button.textContent = 'View Less';
        } else {
            hiddenCompanies.classList.add('d-none');
            button.textContent = 'View More';
        }
    }
</script>


<script>
    document.querySelectorAll('.alphabet-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            let selectedLetter = this.dataset.letter.toLowerCase();

            document.querySelectorAll('.company-item').forEach(function(item) {
                let companyName = item.getAttribute('data-company-name').toLowerCase();
                item.style.display = (selectedLetter === 'all' || companyName.startsWith(selectedLetter)) ? 'block' : 'none';
            });
        });
    });
</script>
<script>
document.querySelectorAll('.alphabet-btn').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let selectedLetter = this.dataset.letter.toLowerCase();

        if (selectedLetter === 'all') {
            // Redirect to the clients.search route
            window.location.href = "{{ route('clients.search') }}";
        } else {
            // Filter company items based on the selected letter
            document.querySelectorAll('.company-item').forEach(function(item) {
                let companyName = item.getAttribute('data-company-name').toLowerCase();
                item.style.display = companyName.startsWith(selectedLetter) ? 'block' : 'none';
            });
        }
    });
});
</script>

<script>
    function showTooltip(element) {
        if (window.innerWidth <= 768) { // For mobile devices
            let tooltip = document.createElement("div");
            tooltip.className = "mobile-tooltip";
            tooltip.innerText = element.getAttribute("title");
            document.body.appendChild(tooltip);

            let rect = element.getBoundingClientRect();
            tooltip.style.left = `${rect.left + window.scrollX}px`;
            tooltip.style.top = `${rect.bottom + window.scrollY}px`;

            setTimeout(() => {
                tooltip.remove();
            }, 2000); // Remove after 2 seconds
        }
    }
</script>


@endsection
