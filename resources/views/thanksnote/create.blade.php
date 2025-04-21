<!-- Author:Divya
Description:Thanksnote creation
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
        color: red;
        padding: 15px;
        text-align: center;
        font-size: 20px;
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



    /* Hide number input spinners */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }



    /* Ensure form fields stack properly on smaller screens */
    @media (max-width: 576px) {
        .container-wrapper {
            padding: 15px;
            margin-top: 20px !important;
            /* Adjust this value to push the form down */
        }
    }

    /* Make the table responsive */
    .table-responsive {
        overflow-x: auto;
    }

    .dropdown-menu.show {
        display: block;
        overflow-y: scroll;
        height: 270px;
        width: 388px;
    }
</style>

<div class="container-wrapper mt-4">
    <!-- Header -->
    <div class="header text-center">
        <h3 style="color:white;    font-weight: bold;">Raise Thanksnote</h3>
    </div>

    <!-- Outer Card -->
    <div class="card shadow-lg">
        <div class="card-body" style="background-color: white; border-radius: 10px; padding: 20px;">

            <!-- Inner Card for Form -->
            <div class="card shadow-sm">
                <div class="card-body" style="background-color: #d3cce3; border-radius: 10px; padding: 20px;">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-auto text-center" role="alert" style="max-width: 400px;">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('thanksnote.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Source Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Source Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" readonly>
                                </div>
                            </div>

                            <!-- Thanksnote To -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thanksnote_to">Thanksnote To*</label>
                                    <!-- Custom Dropdown -->
                                    <div class="dropdown">
                                        <!-- Button to show selected member -->
                                        <button id="thanksnote_to_btn" class="btn btn-light form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Member
                                        </button>

                                        
                                        <!-- Dropdown menu with member options -->
                                        <ul class="dropdown-menu" aria-labelledby="thanksnote_to_btn">
                                            @foreach($thanksnoteMembers as $member)
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    data-id="{{ $member->id }}"
                                                    data-photo="{{ asset('storage/app/public/' . $member->profile_photo) }}"
                                                    data-name="{{ $member->first_name }} {{ $member->last_name }}">
                                                    <!-- Member Photo -->
                                                    {{ $member->first_name }} {{ $member->last_name }}   &nbsp;
                                                    &nbsp; &nbsp;
                                                    <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}" alt="Profile" width="30" height="30" style="border-radius: 50%; margin-right: 10px;">
                                                    
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Display selected member's photo and name below the dropdown -->
                                    <div id="selected-member-info" style="display: none; margin-top: 10px;">
                                        <img id="selected-member-image" src="" alt="Selected Member" width="120" height="120" style="border-radius: 10px;">
                                        <div id="selected-member-name" style="font-weight: bold; margin-top: 5px;"></div>
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
                        </div>

                        <div class="row">
                            <!-- Reference Title -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reference_id">Reference Title*</label>
                                    <select name="reference_id" id="reference_id" class="form-control" required>
                                        <option value="">Select Reference</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quoted Reference Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quoted Reference Amount</label>
                                    <input type="text" id="quoted_amount" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thanksnote_title">Thanksnote Title*</label>
                                    <input type="text" name="thanksnote_title" class="form-control" required maxlength="25">
                                </div>
                            </div>


                            <!-- Thanksnote Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thanksnote_amount">Thanksnote Amount*</label>
                                    <input type="number" id="thanksnote_amount" name="thanksnote_amount" class="form-control" max="999999999999999" required>
                                </div>
                            </div>
                        </div>

                        <!-- Thanksnote Due Table (Hidden Initially) -->
                        <div class="row">
                            <div class="col-12">
                                <div id="thanksnote_due_table" class="card p-3 mt-3" style="display: none;">
                                    <h5>Thanksnote Due Details</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-dark">
                                            <thead>
                                                <tr>
                                                    <th>Thanksnote Title</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="due_table_body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit Thanksnote</button>
                        </div>
                    </form>
                </div> <!-- Inner Card Body Ends -->
            </div> <!-- Inner Card Ends -->

        </div> <!-- Outer Card Body Ends -->
    </div> <!-- Outer Card Ends -->
</div>


<script>
    document.getElementById("thanksnote_to").addEventListener("change", function() {
        var memberId = this.value;

        fetch(`/thanksnote/get-references/${memberId}`)
            .then(response => response.json())
            .then(data => {
                let referenceDropdown = document.getElementById("reference_id");
                referenceDropdown.innerHTML = '<option value="">Select Reference</option>';

                data.forEach(ref => {
                    let option = new Option(ref.title, ref.id);
                    option.setAttribute("data-amount", ref.amount);
                    referenceDropdown.appendChild(option);
                });

                referenceDropdown.dispatchEvent(new Event("change"));
            })
            .catch(error => console.error("Error fetching references:", error));
    });

    document.getElementById("reference_id").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var quotedAmountField = document.getElementById("quoted_amount");
        var thanksnoteDueTable = document.getElementById("thanksnote_due_table");
        var dueTableBody = document.getElementById("due_table_body");

        if (selectedOption.value) {
            var amount = selectedOption.getAttribute("data-amount");
            quotedAmountField.value = amount ? `₹ ${parseFloat(amount).toLocaleString('en-IN')}` : "";

            fetch(`/thanksnote/get-due-payments/${selectedOption.value}`)
                .then(response => response.json())
                .then(data => {
                    dueTableBody.innerHTML = "";
                    if (data.length > 0) {
                        thanksnoteDueTable.style.display = "block";
                        data.forEach(payment => {
                            dueTableBody.innerHTML += `
                            <tr>
                                <td>${payment.title}</td>
                                <td>₹ ${parseFloat(payment.amount).toLocaleString('en-IN')}</td>
                                <td>${formatDate(payment.date)}</td>
                            </tr>`;
                        });
                    } else {
                        thanksnoteDueTable.style.display = "none";
                    }
                });
        } else {
            quotedAmountField.value = "";
            thanksnoteDueTable.style.display = "none";
        }
    });

    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear().toString().slice(-2);

        let hours = date.getHours();
        let minutes = date.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'

        return `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;
    }
</script>


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
@endsection