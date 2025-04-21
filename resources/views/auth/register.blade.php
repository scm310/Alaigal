<!doctype html>
<html lang="en">

<head>
    <title>{{ isset($gf) ? $gf->title : '' }}</title>
    <link rel="icon" type="image/png" href="{{ isset($gf) ? asset('storage/app/public/favicon/' . $gf->logo) : '' }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        /* Style the form container */
        #vendor-register-form {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: linear-gradient(109.6deg, rgb(204, 228, 247) 11.2%, rgb(237, 246, 250) 100.2%);
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }

        /* Style form labels */
        #vendor-register-form label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
            font-size: 13px;
        }

        /* Style input fields */
        #vendor-register-form .form-control {
            width: 100%;
            padding: -1px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        /* Add focus effect to inputs */
        #vendor-register-form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        /* Style select dropdown */
        #vendor-register-form select {
            cursor: pointer;
            background: #fff;
        }

        /* Style the submit button */
        #vendor-register-form button {
            padding: 2px 20px;
            font-size: 16px;
            border: none;
            background: linear-gradient(110.6deg, rgb(184, 142, 252) 2.2%, rgb(104, 119, 244) 100.2%);
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        /* Hover effect for the button */
        #vendor-register-form button:hover {
            background: #555;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            #vendor-register-form .col-md-6 {
                width: 100%;
            }
        }

        a {
            color: black;
            text-decoration: none;
            transform: translateY(20px);
        }

        h2 {
            margin-left:170px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h3{
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }




        .feature-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .feature-box {
            text-align: center;
            flex: 1;
        }

        .feature-box i {
            font-size: 24px;
            color: rgb(88, 169, 255);
            margin-bottom: 10px;
        }

        .feature-box p {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .separator {
            width: 1.5px;
            height: 40px;
            background: lightblue;
        }

        h1 {
            text-align: center;
            margin: 3rem 0;
        }

        li {
            list-style: none;
        }

        .carousel {
            position: relative;
            height: 300px;
            width: 500px;
            margin: 0 auto;
            margin-bottom: 10rem;
        }

        .carousel__p {
            width: 100%;
            height: 100%;

        }

        .carousel__track-container {
            background: radial-gradient(circle at 18.7% 37.8%, rgb(250, 250, 250) 0%, rgb(225, 234, 238) 90%);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.7);
            /* Black shadow */
            height: 80%;
            width: 98%;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            margin-left: 10px;
            margin-top: 65px;
        }

        .carousel__track {
            padding: 0;
            margin: 0;
            position: relative;
            height: 100%;
            transition: transform 0.4s ease-in-out;
        }

        .carousel__slide {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .carousel__button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background-color: transparent;
            cursor: pointer;
            transition: all 0.2s ease-in;
        }

        .carousel__button--left {
            left: -40px;
        }

        .carousel__button--right {
            right: -40px;
            transform: translateY(-50%) rotate(180deg)
        }

        .carousel__button img {
            width: 25px;
            display: none;
        }

        .carousel__nav {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            gap: 1rem;
        }

        .carousel__indicator {
            border: 0;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            cursor: pointer;
        }

        .carousel__indicator.current-slide {
            background: rgba(0, 0, 0, 0.9);
        }

        .is-hidden {
            display: none;
        }
    </style>

    <style>
        .container1 {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            display: flex;
            align-items: center;
            /* Align items in the center */
            justify-content: space-between;
            /* Add space between carousel and form */
            gap: 20px;
            /* Adds spacing between carousel and form */
            flex-wrap: wrap;
            /* Allows wrapping on smaller screens */
        }

        .carousel {
            flex: 1;
            /* Allow the carousel to take available space */
            max-width: 50%;
            /* Restrict the max width */
        }

        .form-container {
            flex: 1;
            /* Allow the form to take available space */
            max-width: 50%;
            /* Restrict the max width */
        }

        .content {
            text-align: center;
            margin-top: 40px;
        }

        .form-container {
            max-width: 520px;
            /* Adjust width */
            padding: 15px;
            margin: auto;
        }



        .form-control {
            height: 35px;
            font-size: 14px;
            width: 100%;
        }

        .btn-dark {
            height: 45px;
            width: 120px;
            border-radius: 24px !important;
            font-size: 14px;
        }

        .image {
            border-radius: 50%;
            margin-left:280px;
            margin-top: 10px;
        }

        .banner {
            width: 100%;
        }





        .glow-on-hover {
            width: 150px;
            height: 40px;
            border: none;
            outline: none;
            color: white;
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
        }

        .glow-on-hover:before {
            content: '';
            background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing 20s linear infinite;
            opacity: 0;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
            color: white;
        }

        .glow-on-hover:active {
            color: white;
        }

        .glow-on-hover:active:after {
            background: transparent;
        }

        .glow-on-hover:hover:before {
            opacity: 1;
        }

        .glow-on-hover:after {
            z-index: -1;
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: #111;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        @keyframes glowing {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .btn:hover {
            color: white;
        }

        .seller {
            transform: translateY(-5px);
        }

        .testimonial {
            transform: translateY(55px);
        }


        @media screen and (max-width: 768px) {

            /* Make banner image responsive */
            .banner {
                width: 100%;
                height: auto;
            }


            /* Adjust heading spacing */
            h2 {
                transform: translateX(9px);
                text-align: center;
                font-size: 1.5rem;
            }

            .carousel {
                max-width: 350px;
            }

            /* Adjust button */
            .image {
                margin-left:143px;
            }



            .feature-box p {
                font-size: 10px;
            }

            .form-container {
                order: -1;
                /* Move form to the top */
                width: 100%;
                /* Ensure full width */
            }


            .feature-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .feature-box {
                width: 30%;
                /* Adjust width to fit three items in one row */
                padding: 10px;
            }

            .feature-box:nth-child(n+6) {
                display: none;
                /* Hide items beyond the first three */
            }

            .testimonial {
                transform: translateY(563px) !important;
                margin-left: 0px;
            }


            .seller {
                transform: translateY(-5px);
                margin-left: 0px;
            }


            .row1 {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                /* Ensures proper spacing */
            }

            .row1 .col-md-6 {
                flex: 0 0 48%;
                /* Two fields per row */
                max-width: 48%;
            }

            .row1 .col-md-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .carousel__track-container {
                height: 100%;
                margin-left:4px;
            }

        }


        @media (max-width: 768px) {
    .container1 {
        display: inline-grid;
    }
    .form-container {
        order: 1;
        width: 100%; /* Ensure full width */
    }
    .carousel {
        margin-bottom: 7rem;
        order: 2;
        width: 100%; /* Ensure full width */
        margin-top:-50px; /* Add spacing */
    }

    .carousel__button--right {
            right:0px !important;
        }

}

    </style>
    <div>
        <img src="assets/images/banner.png" alt="" height="198.6" class="banner">
    </div>

    <div class="feature-container">
        <div class="feature-box">
            <i class="fas fa-users"></i>
            <p>2000 TIEPMD Members</p>
        </div>
        <div class="separator"></div>
        <div class="feature-box">
            <i class="fas fa-wallet"></i>
            <p>7* days secure & regular payments</p>
        </div>
        <div class="separator"></div>
        <div class="feature-box">
            <i class="fas fa-percentage"></i>
            <p>Low cost of doing business</p>
        </div>
        <div class="separator"></div>
        <div class="feature-box">
            <i class="fas fa-phone-volume"></i>
            <p>One click Seller Support </p>
        </div>
        <div class="separator"></div>
        <div class="feature-box">
            <i class="fas fa-shopping-bag"></i>
            <p>Access to Marketplace</p>
        </div>
    </div>


    <h2 style="margin-bottom:-40px;" class="testimonial">Member Success Stories</h2>
    <div class="container1">
        <div class="carousel">
            <button class="carousel__button carousel__button--left is-hidden">
                <img src="https://www.iconpacks.net/icons/2/free-arrow-left-icon-3099-thumb.png" alt="left">
            </button>

            <div class="carousel__track-container">
                <ul class="carousel__track">
                    @foreach($testimonials as $testimonial)
                    <li class="carousel__slide {{ $loop->first ? 'current-slide' : '' }}">
                        <img src="{{ asset('storage/app/public/'.$testimonial->image) }}" alt="{{ $testimonial->name }}" width="60" height="60" class="image">
                        <p class="text-center">{{ $testimonial->name }}</p>
                        <p class="content text-center">{{ $testimonial->message }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>

            <button class="carousel__button carousel__button--right">
                <img src="https://www.iconpacks.net/icons/2/free-arrow-left-icon-3099-thumb.png" alt="right">
            </button>

            <div class="carousel__nav">
                @foreach($testimonials as $testimonial)
                <button class="carousel__indicator {{ $loop->first ? 'current-slide' : '' }}"></button>
                @endforeach
            </div>
        </div>

        <div class="form-container">

            <h3 class="text-center">Register a New Account</h3>

            <form id="vendor-register-form" action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="row row1">

                    <div class="col-md-6 form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                            placeholder="First Name" value="{{ old('first_name') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                            placeholder="Last Name" value="{{ old('last_name') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email Address" value="{{ $errors->has('email') ? '' : old('email') }}" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                            placeholder="Phone Number" value="{{ $errors->has('phone_number') ? '' : old('phone_number') }}" required>
                        @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control"
                            placeholder="Company Name" value="{{ old('company_name') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control"
                            placeholder="Location" value="{{ old('location') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" id="designation" class="form-control"
                            placeholder="Designation" value="{{ old('designation') }}" required>
                    </div>
                </div>
                <div class="col-12 form-group mt-3 d-flex justify-content-center align-items-center text-center">
                    <input type="checkbox" id="terms" required style="margin-right: 10px;">
                    <label for="terms" class="mb-0">
                        <a href="{{ route('terms') }}" target="_blank">I accept the terms and conditions</a>
                    </label>
                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn-submit custom-btn" style="background-color: #866ec7; border-radius: 8px; padding: 10px 20px;">
                        Register
                    </button>
                </div>

                <div class="text-center mt-2">
                    <p>Already have an account? <a href="{{ route('memberlogin') }}" style="color: #866ec7; font-weight: bold;">Login here</a></p>
                </div>


            </form>


        </div>
    </div>

    <script>
        const track = document.querySelector(".carousel__track"); // ul
        const slides = Array.from(track.children); // li items
        const nextButton = document.querySelector(".carousel__button--right");
        const prevButton = document.querySelector(".carousel__button--left");
        const dotsNav = document.querySelector(".carousel__nav");
        const dots = Array.from(dotsNav.children);

        const slideWidth = slides[0].getBoundingClientRect().width;
        let autoPlayInterval;

        // Position slides
        const setSlidePosition = (slide, index) => {
            slide.style.left = slideWidth * index + "px";
        };
        slides.forEach(setSlidePosition);

        const moveToSlide = (track, currentSlide, targetSlide) => {
            if (!targetSlide) return;
            track.style.transform = "translateX(-" + targetSlide.style.left + ")";
            currentSlide.classList.remove("current-slide");
            targetSlide.classList.add("current-slide");
        };

        const updateDots = (currentDot, targetDot) => {
            currentDot.classList.remove("current-slide");
            targetDot.classList.add("current-slide");
        };

        // Function to move to next slide automatically
        const moveNextSlide = () => {
            const currentSlide = track.querySelector(".current-slide");
            const nextSlide = currentSlide.nextElementSibling || slides[0]; // Loop back
            const currentDot = dotsNav.querySelector(".current-slide");
            const nextDot = currentDot.nextElementSibling || dots[0];
            moveToSlide(track, currentSlide, nextSlide);
            updateDots(currentDot, nextDot);
        };

        // Auto-play every 5 seconds
        const startAutoPlay = () => {
            clearInterval(autoPlayInterval);
            autoPlayInterval = setInterval(moveNextSlide, 5000);
        };

        // Pause autoplay when manually interacted with
        const resetAutoPlay = () => {
            clearInterval(autoPlayInterval);
            startAutoPlay();
        };

        // Button events
        nextButton.addEventListener("click", () => {
            moveNextSlide();
            resetAutoPlay();
        });

        prevButton.addEventListener("click", () => {
            const currentSlide = track.querySelector(".current-slide");
            const prevSlide = currentSlide.previousElementSibling || slides[slides.length - 1];
            const currentDot = dotsNav.querySelector(".current-slide");
            const prevDot = currentDot.previousElementSibling || dots[dots.length - 1];
            moveToSlide(track, currentSlide, prevSlide);
            updateDots(currentDot, prevDot);
            resetAutoPlay();
        });

        // Dots navigation
        dotsNav.addEventListener("click", (e) => {
            const targetDot = e.target.closest("button");
            if (!targetDot) return;
            const currentSlide = track.querySelector(".current-slide");
            const currentDot = dotsNav.querySelector(".current-slide");
            const targetIndex = dots.findIndex((dot) => dot === targetDot);
            const targetSlide = slides[targetIndex];
            moveToSlide(track, currentSlide, targetSlide);
            updateDots(currentDot, targetDot);
            resetAutoPlay();
        });

        // Start autoplay on page load
        startAutoPlay();
    </script>



    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        document.getElementById("phone_number").addEventListener("input", function() {
            let phoneInput = this.value;
            let phoneError = document.getElementById("phoneError");

            // Remove non-numeric characters
            this.value = phoneInput.replace(/\D/g, '');

            // Validate length
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); // Limit to 10 digits
            }

            // Show error message if not exactly 10 digits
            if (this.value.length === 10) {
                phoneError.textContent = ""; // No error
            } else {
                phoneError.textContent = "Phone number must be exactly 10 digits.";
            }
        });
    </script>


    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('memberlogin') }}"; // Redirect to login page on OK
                }
            });
        });
    </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lazyBg = document.querySelector(".lazy-bg");
            if (lazyBg) {
                let bgImage = lazyBg.getAttribute("data-bg");
                lazyBg.style.backgroundImage = `url('${bgImage}')`;
            }
        });
    </script>




    </body>

</html>