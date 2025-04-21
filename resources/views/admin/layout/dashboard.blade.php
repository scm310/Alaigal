@extends('admin.layout.sidenavbar')

@section('content')

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background: #353540;
            flex-direction: column;
         
        }

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Responsive Grid Layout */
        .l-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
            width: 100%;
            max-width: 1200px;
            padding: 20px;
        }

        @media screen and (max-width: 760px) {
            .l-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 480px) {
            .l-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        /* Game Card */
        .b-game-card {
            position: relative;
            width: 100%;
            padding-bottom: 130%;
            perspective: 1000px;
            border-radius: 15px;
            overflow: hidden;
        }

        .b-game-card__cover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(120deg, #866ec7, #6f4ab6, #ff61a6);
            background-size: 200% 200%;
            animation: shine 9s ease infinite;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 10px;
        }

        @keyframes shine {
            0% { background-position: 200% 200%; }
            50% { background-position: 0% 0%; }
            100% { background-position: 200% 200%; }
        }

        /* Content inside the card */
        .b-game-card__cover .content h2 {
            font-size: 2.5rem;
            color: white;
        }

        .b-game-card__cover .content p {
            font-size: 1.2rem;
            color: white;
            margin-top: 5px;
        }

        @keyframes oxygen-pump {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.oxygen-pump-card {
    animation: oxygen-pump 2s ease-in-out infinite;
}


/* Default styling for desktop */
.custom-card {
        width: 19%; /* Ensures 5 cards per row with spacing */
        margin: 0.5%; /* Adds spacing between cards */
    }

    .card {
        margin-bottom: 15px; /* Adds bottom spacing */
    }

    /* Tablet view: 2 cards per row */
    @media (max-width: 768px) { 
        .custom-card {
            width: 48%; /* 2 cards per row */
            margin: 1%; /* Adds spacing */
        }
    }

    /* Mobile view: 1 card per row */
    @media (max-width: 480px) { 
        .custom-card {
            width: 100%; /* 1 card per row */
            margin-bottom: 10px;
        }
    }


        /* Responsive Font Adjustments */
        @media screen and (max-width: 480px) {
            .b-game-card__cover .content h2 {
                font-size: 2rem;
            }

            .b-game-card__cover .content p {
                font-size: 1rem;
            }
        }

h4{
    color: white;
}



.card1 {
    position: relative;
    max-width: 400px;
    padding: 24px;
    background: linear-gradient(to bottom right, #ec4899, #8b5cf6);
    border-radius: 16px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    color: white;
    text-align: center;
}

h1 {
    font-size:20px;
    font-weight:500;
    margin-bottom: 16px;
}

p {
    font-size: 14px;
    margin-bottom: 24px;
}

.image-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-container img {
    border-radius: 8px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
}

.card-row {
    display: flex;
    gap: 20px; /* space between cards */
    flex-wrap: wrap; /* makes it responsive */
    justify-content: center; /* optional: centers the row */
}

.card1 {
    flex: 0 0 45%; /* two cards per row */
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}


    </style>



<style>
    .dashboard-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
    }

    .dashboard-card {
        flex: 1 1 calc(25% - 20px);
        background: #5A189A; /* Default color, override individually */
        border-radius: 10px;
        padding: 20px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        text-align: center;
        min-width: 180px;
    }

    .dashboard-card.orange { background: #F15A24; }
    .dashboard-card.green { background: #28A745; }
    .dashboard-card.yellow { background: #F39C12; }
    .dashboard-card.purple { background: #9B59B6; }

    .dashboard-card h4 {
        font-size: 28px;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    .dashboard-card p {
        font-size: 16px;
        margin: 0;
    }

    @media (max-width: 768px) {
        .dashboard-card {
            flex: 1 1 100%;
        }
    }
    .card-row {
    display: flex;
    justify-content: space-between;
    gap: 20px; /* Adjust the gap between cards */
}

.card1 {
    flex: 1; /* Allow each card to take equal width */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    background: linear-gradient(135deg, #d1e0ff, #fdd0e8);
}



.card1:nth-child(2) {
    background: linear-gradient(135deg, #ffe1b3, #d5a2ff);
}

.card1:nth-child(3) {
    background: linear-gradient(135deg, #dbe7ff, #ffd6d6);
}

.card1:nth-child(4) {
    background: linear-gradient(135deg, #cbd9ff, #f5d4e6);
}
.card-content {
    display: flex;
    align-items: center;
}

.profile-img {
    width: 50px; /* Adjust the size of the image */
    height: 50px;
    border-radius:12px;
    margin-right: 10px;
    object-fit: fill;
}

.card-text {
    display: flex;
    flex-direction: column;
    width: 135px;
    color: black;
}

.card-text strong {
    margin-bottom: 5px;
}

.card1 h5 {
    margin-bottom: 15px;
    font-size: 16px;
}


</style>

<div class="dashboard-cards mt-5">
    <div class="dashboard-card purple">
        <h4>₹ {{ number_format($totalAmount, 0) }}</h4>
        <p>Total Reference Amount</p>
    </div>
    <div class="dashboard-card yellow">
        <h4>₹ {{ number_format($totalAmounts, 0) }}</h4>
        <p>Total ThanksNote Amounts</p>
    </div>
    <div class="dashboard-card green">
        <h4>{{ $referenceCount }}</h4>
        <p>Total Number of Reference</p>
    </div>
    <div class="dashboard-card orange">
        <h4>{{ $membersCount }}</h4>
        <p>Total No. of Members</p>
    </div>
</div>

<br>

<div class="card-row mt-1">
    <div class="card1">
        <h5>Highest Reference Count</h5>
        @if($topReferrer)
            @php
                $matchedMember = $members->firstWhere('id', $topReferrer->reference_from);
            @endphp

            @if($matchedMember)
                <div class="card-content">
                <div class="card-text">
                        <strong>{{ $matchedMember->first_name }} {{ $matchedMember->last_name }}</strong>
                        <strong>{{ $topReferrer->total }}</strong>
                    </div>
                    <img src="{{ asset('storage/app/public/' . $matchedMember->profile_photo) }}" alt="Profile Photo" class="profile-img">
                </div>
            @else
                <p>Top referring member not found.</p>
            @endif
        @else
            <p>No references found.</p>
        @endif
    </div>

    <div class="card1">
        <h5>Highest Thanks Note Count</h5>
        @if($topThanksNote)
            <div class="card-content">
            <div class="card-text">
                    <strong>{{ $topThanksNote->first_name }} {{ $topThanksNote->last_name }}</strong>
                    <strong>{{ $topThanksNote->total_thanks }}</strong>
                </div>
                <img src="{{ asset('storage/app/public/' . $topThanksNote->profile_photo) }}" alt="Profile Photo" class="profile-img">      
            </div>
        @else
            <p>No thanks notes found.</p>
        @endif
    </div>

    <div class="card1">
        <h5>Highest Reference Giver of this week</h5>
        @if($topReferenceGiver)
            <div class="card-content">
            <div class="card-text">
                    <strong>{{ $topReferenceGiver->first_name }} {{ $topReferenceGiver->last_name }}</strong>
                    <strong>₹{{ number_format($topReferenceGiver->amount, 0) }}</strong>
                </div>
                <img src="{{ asset('storage/app/public/' . $topReferenceGiver->profile_photo) }}" alt="Profile Photo" class="profile-img">
         
            </div>
        @else
            <p>No reference data found for this week.</p>
        @endif
    </div>

    <div class="card1">
        <h5>Highest Thanks Note Giver of this week</h5>
        @if($topThanksNoteGiver)
            <div class="card-content">
            <div class="card-text">
                    <strong>{{ $topThanksNoteGiver->first_name }} {{ $topThanksNoteGiver->last_name }}</strong>
                    <strong>₹{{ number_format($topThanksNoteGiver->thanksnote_amount, 0) }}</strong>
                </div>
                <img src="{{ asset('storage/app/public/' . $topThanksNoteGiver->profile_photo) }}" alt="Profile Photo" class="profile-img">

            </div>
        @else
            <p>No thanksnote data found for this week.</p>
        @endif
    </div>
</div>



<br>
    
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-center"> <!-- Flexbox for responsiveness -->
        @foreach ([
            'products' => 'Products', 
            'services' => 'Services', 
            'testimonials' => 'Testimonials', 
            'clients' => 'Clients', 
            'completed_projects' => 'Projects'
        ] as $key => $title)
            <div class="custom-card"> <!-- Responsive card wrapper -->
                <div class="card shadow-sm p-2" style="font-size: 14px;"> 
                    <div class="card-header text-white text-center fw-bold p-2" 
                        style="background: linear-gradient(to right, #1d2b64, #f8cdda);">
                        {{ $title }}
                    </div>
                    <div class="card-body p-2">
                        @foreach ($members as $member)
                            @if ($member->{$key . '_count'} > 0)
                                <div class="d-flex align-items-center mb-2 p-2 border rounded bg-light"> 
                                    <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}" 
                                         alt="Profile Image" 
                                         class="rounded-circle" 
                                         width="40" height="40" 
                                         style="margin-right: 10px;"> 
                                    <div class="ms-2"> 
                                        <h6 class="mb-0 fw-bold" style="font-size: 12px;">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </h6>
                                        <small class="text-muted">{{ $member->{$key . '_count'} }} {{ $title }}</small>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>












@endsection
