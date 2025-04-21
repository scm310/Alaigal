@extends('memberlayout.navbar')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* cj creation */
        .zoom-image {
            transition: transform 0.3s ease-in-out;
        }

        .zoom-image:hover {
            transform: scale(2.5);
            /* Zoom effect */
        }

        .bg-primary {
            background-color: white !important;
        }

        /* cj creation end */
        .container-wrapper {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
            margin-top: 20px;

        }

        .header {
            background: linear-gradient(to right, #1d2b64, #f8cdda);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 15px;
            height: 70px;
        }

        .nav-tabs .nav-item .nav-link {
            color: white;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-tabs .nav-item .nav-link.active {
            background: linear-gradient(to right, #1d2b64, #f8cdda);

            color: white;
        }

        .nav-tabs .nav-item .nav-link:not(.active) {
            background: linear-gradient(to right, #bdc3c7, #2c3e50);
            color: white;
        }

        .tab-content {
            background: #d3cce3;
            padding: 20px;
            border-radius: 10px;
            margin-top: 10px;
        }

        /* Default inactive tab background */
        .nav-pills .nav-link {
            background: linear-gradient(to right, #bdc3c7, #2c3e50);
            color: white;
            /* Ensures text is visible */
            border-radius: 5px;
            transition: 0.3s;
        }

        /* Active tab background */
        .nav-pills .nav-link.active {
            background: linear-gradient(to right, #1d2b64, #f8cdda);
            color: white;
            /* Keeps text readable */
            font-weight: bold;
        }

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

        .progress-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px;
        }

        .progress-circle {
            position: relative;
            width: 50px;
            height: 50px;
            margin-top: -10px;
        }



        svg {
            transform: rotate(360deg);
            width: 50px;
            height: 50px;
        }

        circle {
            fill: none;
            stroke-width: 5;
            stroke-linecap: round;
        }

        .bg {
            stroke: #eee;
        }

        .progress {
            stroke: #1d2b64;
            stroke-dasharray: 283;
            stroke-dashoffset: 0;
            /* 100% completed */
        }

        .percentage {
            font-size: 30px;
            ! fill: orange;
            font-weight: bold;
            text-anchor: middle;
            dominant-baseline: middle;
        }

        .progress-container {
            display: inline-block;
            position: relative;

        }

        .progress-tooltip {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            background: #1d2b64;
            color: white;
            padding: 8px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            display: none;
            z-index: 10;
        }

        .progress-container:hover .progress-tooltip {
            display: block;
        }

        #profileTabs {
            gap: 15px;
        }

        .custom-alert {
            width: 42%;
            margin: 0 auto;
            font-size: 16px;
            padding: 5px;
        }
        .alert-dismissible .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.15rem 0.25rem;
    color: inherit;
}

        /* Responsive styling */

        /* Mobile View: Two buttons per row */
        @media (max-width: 767px) {
            .mobile-two-columns {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                padding: 0;
            }

            .mobile-two-columns .nav-item {
                flex: 0 0 48%;
                /* 48% width for two items per row */
                text-align: center;
                margin: 1%;
                /* Small margin for spacing */
            }

            .mobile-two-columns .nav-link {
                width: 100%;
                padding: 6px;
                text-align: center;
                font-size: 10px;
                border-radius: 5px;
            }

            #profileTabs {
                gap: 0px;
            }

            .container-wrapper {
                margin-top: 52px;
            }

            .container {
                width: 109%;
                margin-left: -15px;
            }

            #profileTabs {
                gap: 0px !important;
            }

            .progress-circle {
                margin-left: 40px;
            }
        }

        @media (max-width: 768px) {
            .custom-alert {
                width: 80%;
                font-size: 14px;
                padding: 12px;
                margin-top: -18px;

            }

            .mt-6,
            .my-6 {
                margin-top: 3.5rem !important
            }

        }

        @media (max-width: 480px) {
            .custom-alert {
                width: 80%;
                font-size: 13px;
                padding: 10px;
                margin-top: -18px;

            }

        }
    </style>

    <div class="container-wrapper mt-6">

        <div id="profileToast" class="toast position-fixed top-0 end-0 p-3"
        style="z-index: 999; right: 25px; background-color: #e7cfcf; display: none;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Notice</strong>
            <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">

            </button>
        </div>
        <div class="toast-body">
            <b>In order to become a prime member, please follow the steps below:</b>
            <ol class="toast-list">
                <li>Add your products or services in TIEPMD Marketplace.</li>
                <li>Must have a website.</li>
                <li>Add a minimum of 10 clients.</li>
                <li>Add a minimum of 10 client testimonials.</li>
                <li>Add a minimum of 5 products or services.</li>
                <li>Add a minimum of 10 completed projects.</li>
            </ol>
        </div>
        <div class=" text-center mt-1">
            <button id="okButton" class="btn btn-primary btn-sm  " style="font-size: 10px">OK</button>
        </div>
    </div>
        <div class="header">Member Profile</div>
        <!-- Toast Message (Hidden by Default) -->


        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-body">

                    <div class="d-flex justify-content-end ">
                        <span class="mb-3"onclick="showMessage()" title="Click to know " style="font-weight: bolder; cursor: pointer;color: #30cfe9; margin-top: -20px; " data-toggle="tooltip">Become a Prime Member? </span>
                        {{-- <i class="bi bi-info-circle fs-4 text-primary" style="cursor: pointer;" data-toggle="tooltip"
                            title="Click for more details" ></i> --}}
                    </div>





                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show custom-alert text-center mt-1 mb-2 "
                            role="alert">
                            {{ session('success') }}
                            &nbsp;&nbsp;
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


                            <p id="message" class="p-2 text-center" style="color: rgb(250, 0, 0); font-weight: bold ">
                                Please fill in all the fields in the form. The application will become fully functional only if all the fields are filled in and reaches 100%.
                            </p>



                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills d-flex flex-wrap justify-content-center mobile-two-columns" id="profileTabs"
                        role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basicInfo"
                                role="tab">Personal</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="products-tab" data-toggle="tab" href="#products"
                                role="tab">Products</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="services-tab" data-toggle="tab" href="#services"
                                role="tab">Services</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="clients-tab" data-toggle="tab" href="#clients"
                                role="tab">Clients</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="testimonials-tab" data-toggle="tab" href="#testimonials"
                                role="tab">Testimonials</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="projects-tab" data-toggle="tab" href="#projects"
                                role="tab">Completed Projects</a>
                        </li>

                        <li class="nav-item progress-container position-relative ">
                            <div class="progress-circle">
                                <svg width="50" height="50" viewBox="0 0 100 100">
                                    <!-- Background Circle -->
                                    <circle cx="50" cy="50" r="45" stroke="#ddd" stroke-width="10"
                                        fill="none" />
                                    <!-- Progress Circle -->
                                    <circle id="progressCircle" cx="50" cy="50" r="45" stroke="#ff9800"
                                        stroke-width="10" fill="none" stroke-dasharray="283" stroke-dashoffset="85"
                                        stroke-linecap="round" />
                                    <!-- Percentage Text -->
                                    <text id="progressText" x="50" y="55" text-anchor="middle" font-size="18px"
                                        fill="#ff9800">65%</text>
                                </svg>
                            </div>


                            <!-- Tooltip (Hidden by Default) -->

                            <div class="progress-tooltip" id="progressTooltip">
                                <div id="tool">
                                    @if (!empty($descriptiondata))
                                        @foreach ($descriptiondata as $message)
                                            @if ($message)
                                                <ul>
                                                    <li>
                                                        {{ $message }}
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                                <div id="toolhidden" style="display: none"> <span
                                        style="color: rgb(255, 255, 255)">Verified</span> </div>
                            </div>

                        </li>


                    </ul>


                    <!-- Tabs Content -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="basicInfo" role="tabpanel">
                            @include('members.partials.basic_info')
                        </div>
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            @include('members.partials.products')
                        </div>
                        <div class="tab-pane fade" id="services" role="tabpanel">
                            @include('members.partials.services')
                        </div>
                        <div class="tab-pane fade" id="clients" role="tabpanel">
                            @include('members.partials.clients')
                        </div>
                        <div class="tab-pane fade" id="testimonials" role="tabpanel">
                            @include('members.partials.testimonials')
                        </div>
                        <div class="tab-pane fade" id="projects" role="tabpanel">
                            @include('members.partials.projects')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- //popup --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ✅ Fetch progress values dynamically
            let progressValues = {!! json_encode(array_values($cdata)) !!};

            // ✅ Calculate average progress
            let total = progressValues.reduce((sum, value) => sum + value, 0);
            let progress = Math.round(total / progressValues.length);

            // ✅ Calculate stroke-dashoffset based on progress
            let strokeDashArray = 283; // Full circle length
            let strokeDashOffset = strokeDashArray * (1 - progress / 100);

            // ✅ Select elements safely
            let progressCircle = document.getElementById("progressCircle");
            let progressText = document.getElementById("progressText");


            let tooltip = document.getElementById("progressTooltip");
            let tool = document.getElementById("tool");
            let toolhidden = document.getElementById("toolhidden"); // ✅ Corrected
            let messageText = document.getElementById("message");

            if (progressCircle && progressText) {
                // ✅ Update circle stroke and text based on progress
                progressCircle.setAttribute("stroke-dashoffset", strokeDashOffset);
                progressText.textContent = progress + "%";

                // ✅ Change color to green if 100% completed
                if (progress === 100) {
                    progressCircle.setAttribute("stroke", "#4CAF50"); // Green color
                    progressText.setAttribute("fill", "#4CAF50"); // Green text


                    // ✅ Hide `tool` and show `toolhidden` safely
                    if (tool) tool.style.display = "none";
                    if (toolhidden) toolhidden.style.display = "block";
                    if (tooltip) tooltip.style.backgroundColor = "green";
                    if(messageText) messageText.style.display = "none";
                }
            }
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function switchToNextTab(currentTabId) {
                const tabs = ["basicInfo", "products", "services", "clients", "testimonials", "projects"];
                let currentIndex = tabs.indexOf(currentTabId);
                if (currentIndex >= 0 && currentIndex < tabs.length - 1) {
                    let nextTabId = tabs[currentIndex + 1];
                    document.querySelector(`#${currentTabId}-tab`).classList.remove("active");
                    document.querySelector(`#${nextTabId}-tab`).classList.add("active");
                    document.querySelector(`#${currentTabId}`).classList.remove("show", "active");
                    document.querySelector(`#${nextTabId}`).classList.add("show", "active");
                }
            }

            document.getElementById("saveAndNextBasic").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("basicInfoForm");
                if (form.checkValidity()) {
                    form.submit();
                    switchToNextTab("basicInfo");
                } else {
                    alert("Please fill all required fields.");
                }
            });

            document.getElementById("saveAndNextProducts").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("productsForm");
                let productCount = document.querySelectorAll("#productFields .product-row").length;
                if (productCount > 0) {
                    form.submit();
                    switchToNextTab("products");
                } else {
                    alert("Please add at least one product.");
                }
            });

            document.getElementById("saveAndNextServices").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("servicesForm");
                let serviceCount = document.querySelectorAll("#serviceFields .service-row").length;
                if (serviceCount > 0) {
                    form.submit();
                    switchToNextTab("services");
                } else {
                    alert("Please add at least one service.");
                }
            });

            document.getElementById("saveAndNextClients").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("clientsForm");
                let clientCount = document.querySelectorAll("#clientFields .client-row").length;
                if (clientCount > 0) {
                    form.submit();
                    switchToNextTab("clients");
                } else {
                    alert("Please add at least one client.");
                }
            });

            document.getElementById("saveAndNextTestimonials").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("testimonialsForm");
                let testimonialCount = document.querySelectorAll("#testimonialFields .testimonial-row")
                    .length;
                if (testimonialCount > 0) {
                    form.submit();
                    switchToNextTab("testimonials");
                } else {
                    alert("Please add at least one testimonial.");
                }
            });

            document.getElementById("updateProfile").addEventListener("click", function(event) {
                event.preventDefault();
                let form = document.getElementById("projectsForm");
                form.submit();
                fetch("{{ route('profile.update') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({

                    })
                }).then(() => {
                    Swal.fire({
                        title: "Profile Updated Successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "{{ route('profile.edit') }}";
                    });
                });
            });
        });
    </script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip(); // Activate Tooltip
    });

    function showMessage() {
        let toast = $('#profileToast');
        toast.show(); // Ensure visibility before triggering

        toast.toast({
            delay: 100000
        }).toast('show');

        $('#okButton').on('click', function () {
    $('.toast').css('display', 'none'); // Hides the toast by setting display to none
});
    }
</script>

@endsection
