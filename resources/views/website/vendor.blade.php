@extends('frontend.layout')
@section('content')

@include('frontend.parital.topheader')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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

    .d-flex{
    transform: translateY(-18px);
  }
  .terms{
    transform: translateY(-1px);
  }
  }

  a {
    color: black;
    text-decoration: none;  
    transform: translateY(20px);
  }

  h2 {
    font-size: 1.7rem;
    margin-left:70px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  }

  h4 {
    font-size: 1.7rem;
    margin-left:176px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  }

  .breadcrumb {
    display: flex;
    list-style: none;
    padding: 10px 15px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 20px;
  }

  .breadcrumb li {
    font-size: 14px;
    color: #555;
  }

  .breadcrumb li a {
    text-decoration: none;
    color: #007bff;
    font-weight: 600;
  }

  .breadcrumb li a:hover {
    text-decoration: underline;
  }

  .breadcrumb li::after {
    content: " > ";
    margin: 0 8px;
    color: #888;
  }

  .breadcrumb li:last-child::after {
    content: "";
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
    margin-bottom: 5rem;
  }

  .carousel__p {
    width: 100%;
    height: 100%;

  }

  .carousel__track-container {
    background: radial-gradient(circle at 18.7% 37.8%, rgb(250, 250, 250) 0%, rgb(225, 234, 238) 90%);
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.7);
    /* Black shadow */
    height: 100%;
    width: 98%;
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    margin-left: 0px;
    margin-top: 55px;
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
    padding: 5px 0;
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
    margin-top: 0px;
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
    margin-left: 305px;
    margin-top: 10px;
  }
  .banner {
    width: 100%;
    max-width:1400px; /* Limit max width */

}

/* Ensures image fits well */
.banner img {
    max-width: 100%;
    height: auto;
    object-fit: contain; /* Prevents distortion */
}


/* Responsive Adjustments */
@media (max-width: 1200px) {
    .banner {
        flex-direction: column;
        text-align: center;
    }
    
}

/* Responsive adjustments for larger screens */
@media (min-width: 1200px) {
    .banner {
        width:100%; /* Adjust width for large desktops */
        max-width: 1705px;
    }
}

/* Responsive for medium desktops */
@media (min-width: 992px) and (max-width: 1199px) {
    .banner {
        width:100%; /* Slightly reduce width */
    }
}

  @media screen and (max-width: 768px) {

 /* Make banner image responsive */
 .banner {
      width:-webkit-fill-available;
      height: auto;
    }


    /* Adjust heading spacing */
    h2 {
      transform: translateX(-50px);
      text-align: center;
      font-size: 1.5rem;
    }

    .carousel {
      max-width: 350px;
    }

    /* Adjust button */
    .image {
      margin-left: 145px;
    }


    .container1 {
      display: flex;
      flex-direction: column;
      /* Ensure a vertical layout */
      align-items: center;
      gap: 20px;
      height: 90vh;
      font-size:9px;
      
    }
    .carousel__slide{
      
      width:"20px" ;
      height:"20px";
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

    .carousel {
      margin-top: -50px;
      order: 2;
      /* Move testimonials below */
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
      transform: translateY(450px) !important;
      margin-left: 50px;
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

    .navbar-brand{
    transform: translateY(11px) !important;
  }

  .content{
    font-size: 13px;
  }

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
  .navbar-brand{
    transform: translateY(0px);
  }

  @media (max-width: 767px) {
    .powered-by {
      margin-top: 10px;
      /* Adjust spacing for mobile */
      padding-top: 5px;
      /* Optional: Add padding for better separation */
    }
  }

  
</style>

<nav aria-label="breadcrumb">
  <ul class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li>Become a Member</li>
    <img src="assets/images/banner.png" alt=""  class="banner">
  </ul>

</nav>


<!-- <div>
        <img src="assets/images/banner.png" alt="" height="198.6"  width="1700px" class="banner">
    </div> -->


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


<h4 style="margin-bottom:-40px;" class="testimonial">Member Success Stories</h4>
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
    {{-- Success Message --}}
    @if(session('success'))
    <script>
  Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: "{{ session('success') }}", 
    showConfirmButton: false,
    timer:5000
}).then(() => {
    window.location.href = "{{ route('home') }}"; 
});

    </script>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: {
          !!json_encode(session('error')) !!
        },
        showConfirmButton: true
      });
    </script>
    @endif

    <h2 class="seller">Become a TIEPMD Member</h2>

    <form id="vendor-register-form" action="{{ route('vendor.register.submit') }}" method="POST">
      @csrf
      <div class="row row1">

        <!-- First Name -->
        <div class="col-md-6">
          <label for="first_name">First Name *</label>
          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" required>
        </div>

        <!-- Last Name -->
        <div class="col-md-6">
          <label for="last_name">Last Name *</label>
          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" required>
        </div>

        <!-- Email Address -->
        <div class="col-md-6">
          <label for="email">Email Address *</label>
          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ $errors->has('email') ? '' : old('email') }}" required>
          @error('email')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <!-- Phone Number -->
        <div class="col-md-6">
          <label for="phone_number">Phone Number *</label>
          <input type="text" name="phone_number" id="phone_number"
            class="form-control @error('phone_number') is-invalid @enderror"
            placeholder="Phone Number"
            value="{{ $errors->has('phone_number') ? '' : old('phone_number') }}"
            pattern="\d{10}"
            title="Please enter a valid 10-digit phone number"
            maxlength="10"
            required
            oninput="this.value = this.value.replace(/[^0-9]/g, '')">

          @error('phone_number')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>




        <!-- Company Name -->
        <div class="col-md-6">
          <label for="company_name">Company Name *</label>
          <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" value="{{ old('company_name') }}" required>
        </div>

        <!-- Location -->
        <div class="col-md-6">
          <label for="location">Location *</label>
          <input type="text" name="location" id="location" class="form-control" placeholder="Location" value="{{ old('location') }}" required>
        </div>

        <!-- Designation -->
        <div class="col-md-6">
          <label for="designation">Designation *</label>
          <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" value="{{ old('designation') }}" required>
        </div>

        <div class="col-12 form-group mt-3 d-flex terms justify-content-center align-items-center text-center">
                <input type="checkbox" id="terms" required style="margin-right: 10px;">
                <label for="terms" class="mb-0">
                    <a href="{{ route('terms') }}" target="_blank">I accept the terms and conditions</a>
                </label>
            </div>

        <!-- Submit Button -->
        <div class="col-md-12 text-center mt-3">
          <button class="glow-on-hover btn brown-btn" type="submit">Register</button>
        </div>
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


@include('frontend.parital.footer')


@endsection