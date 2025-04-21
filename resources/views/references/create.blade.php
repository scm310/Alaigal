<!-- Author:Divya
Description:Reference creation
Date:20/03/2025-->


@extends('memberlayout.navbar')

@section('content')

<style>
    .container-wrapper {
        width: 95%;
        max-width: 1500px;
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



    .form-control:focus {
        border-color: #f8cdda;
        box-shadow: 0px 0px 5px rgba(248, 205, 218, 0.7);
    }

    /* Button Styling */
    .btn-primary {
        background-color: #1d2b64;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: 0.3s;
    }






    /* Hide number input spinners (Chrome, Safari, Edge, Opera) */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide number input spinners (Firefox) */
    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Ensure form fields stack properly on smaller screens */
    @media (max-width: 576px) {
        .container-wrapper {
            padding: 15px;
            margin-top: 40px !important;
            /* Adjust this value to push the form down */
        }


    }

    .dropdown-toggle::after {
        display: none;
        transform: translateX(-10px) !important;
    }
</style>

<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header text-center">Raise Reference</div>

    <div class="card shadow-lg">


        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-auto text-center" role="alert" style="max-width: 400px;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Inner Card -->
        <div class="card shadow-sm">
            <div class="card-body" style="background-color: white; border-radius: 10px; padding: 20px;">

                <!-- Form Container -->
                <div style="background-color: #d3cce3; border-radius: 10px; padding: 20px;">
                    <form action="{{ route('references.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Add this inside your form -->
                                <div class="form-group">
                                    <label for="reference_to">Reference Given To*</label>
                                    <input type="hidden" name="reference_to" id="reference_to">

                                    <div class="custom-dropdown">
                                        <button type="button" class="dropdown-toggle btn btn-light form-control" id="dropdownButton">
                                            <span id="selectedMemberText">Select Member</span>
                                        </button>
                                        <ul class="dropdown-menu w-100" id="dropdownList" style="max-height: 300px; overflow-y: auto;">

                                            <li class="px-3 py-2">
                                                <input type="text" class="form-control" id="memberSearchInput" placeholder="Search Member...">
                                            </li>

                                            @foreach($members as $member)
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center"
                                                    data-id="{{ $member->id }}"
                                                    data-name="{{ $member->first_name }} {{ $member->last_name }}"
                                                    data-image="{{ asset('storage/app/public/' . $member->profile_photo) }}">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                    &nbsp; &nbsp; &nbsp;
                                                    <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}" alt="Profile" class="rounded-circle ms-2" width="40" height="40">
                                                </a>

                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <!-- Optional: Add Bootstrap JS if not already included -->
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                            <!-- JavaScript to handle selection -->
                            <script>
                                const dropdownButton = document.getElementById('dropdownButton');
                                const dropdownList = document.getElementById('dropdownList');
                                const selectedMemberText = document.getElementById('selectedMemberText');
                                const selectedMemberInfo = document.getElementById('selectedMemberInfo');
                                const selectedImage = document.getElementById('selectedImage');
                                const selectedName = document.getElementById('selectedName');
                                const referenceTo = document.getElementById('reference_to');

                                // Show/hide dropdown list
                                dropdownButton.addEventListener('click', () => {
                                    dropdownList.classList.toggle('show');
                                });

                                // Handle item selection
                                document.querySelectorAll('.dropdown-item').forEach(item => {
                                    item.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const id = this.getAttribute('data-id');
                                        const name = this.getAttribute('data-name');
                                        const image = this.getAttribute('data-image');

                                        // Set selected info
                                        referenceTo.value = id;
                                        selectedMemberText.innerText = name;
                                        selectedImage.src = image;
                                        selectedName.innerText = name;
                                        selectedMemberInfo.style.display = 'flex';

                                        dropdownList.classList.remove('show');
                                    });
                                });

                                // Close dropdown if clicked outside
                                window.addEventListener('click', function(e) {
                                    if (!dropdownButton.contains(e.target)) {
                                        dropdownList.classList.remove('show');
                                    }
                                });
                            </script>

                            <!-- CSS to style dropdown -->
                            <style>
                                .custom-dropdown {
                                    position: relative;
                                }

                                .custom-dropdown .dropdown-menu {
                                    display: none;
                                    position: absolute;
                                    z-index: 1000;
                                    width: 100%;
                                }

                                .custom-dropdown .dropdown-menu.show {
                                    display: block;
                                }

                                .dropdown-item img {
                                    object-fit: fill;
                                }
                            </style>


                            <!-- Reference Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Reference Title*</label>
                                    <input type="text" name="title" id="title" class="form-control" required maxlength="25">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Reference Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Reference Amount*</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required
                                        min="1" max="999999999999999">
                                </div>
                            </div>

                            <!-- Date (System Date) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Reference Image -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Reference Image (Max: 1MB)</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>


                            <!-- Reference Details -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details">Reference Details</label>
                                    <textarea name="details" id="details" class="form-control" rows="3" maxlength="250" oninput="updateCharCount()"></textarea>
                                    <small id="charCount" class="text-muted">You can enter up to 250 characters.</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit Reference</button>
                        </div>
                    </form>
                </div> <!-- Form container ends -->

            </div>
        </div> <!-- Inner card ends -->

    </div>
</div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("memberSearchInput");
        const dropdownItems = document.querySelectorAll("#dropdownList li a.dropdown-item");

        // Prevent dropdown from closing when clicking inside the input
        searchInput.addEventListener("click", function(e) {
            e.stopPropagation();
        });

        // Search filter logic
        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();

            dropdownItems.forEach(item => {
                const text = item.getAttribute("data-name").toLowerCase();
                if (text.includes(filter)) {
                    item.parentElement.style.display = "";
                } else {
                    item.parentElement.style.display = "none";
                }
            });
        });
    });
</script>


<script>
    document.getElementById('amount').addEventListener('input', function(e) {
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15); // Restrict to 15 digits
        }
    });
</script>

<script>
    document.getElementById("details").addEventListener("input", function() {
        let remaining = 250 - this.value.length;
        document.getElementById("charCount").textContent = "You can enter up to " + remaining + " characters.";
    });
</script>

@endsection