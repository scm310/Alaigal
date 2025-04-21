<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Login</title>
</head>

<body>
  <h1 class="text-center">Vendor Login</h1>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for the eye icon -->

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
      transition: none !important;
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



    h2 {
      margin-left: 180px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }



    h1 {

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
      height: 85%;
      width: 98%;
      position: relative;
      overflow: hidden;
      border-radius: 20px;
      margin-left: 18px;
      margin-top: 70px;
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

    .image {
      border-radius: 50%;
      margin-left: 280px;
      margin-top: 10px;
    }

    .card-header {
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      padding-bottom: 10px;
      border-radius: 20px !important;
    }

    .card {
      width: 400px;
      /* Adjust the width */
      padding: 20px;
      height: 380px;
      border-radius: 8px;
      background: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
      box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
      margin-left: 50px;
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

    .password-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(50%);
      cursor: pointer;
      color: #6c757d;
    }


    .login {
      width: 80px;
      margin-left: 80px;
    }

    .banner {
      width: fit-content;
    }


    @media screen and (max-width: 768px) {

/* Make banner image responsive */
.banner {
  width: 100%;
  height: auto;
}

/* Adjust heading spacing */
h2 {
  transform: translateY(390px) !important; /* Remove unnecessary translateX */
  text-align: center;
  font-size: 1.5rem;
}

/* Adjust image positioning */
.image {
  margin-left: auto;
  margin-right: auto;
  display: block;
}

/* Ensure a vertical layout */
.container1 {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  height: 95vh; /* Remove fixed height */
}

/* Move form to the top */
.form-container {
  order: 1;
  width: 100%;
}

/* Move testimonials below */
.carousel {
  order: 2;
  width: 100% !important;
  margin-bottom: 0rem;
  max-width: 100%;
}

/* Testimonials container adjustments */
.carousel__track-container {
  display: block;
  justify-content: center;
  width: 100%;
  margin-top: 0px;
  margin-left: 0px;
}

/* Centering testimonials */
.carousel__track {
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Adjust feature box text */
.feature-box p {
  font-size: 10px;
}

/* Feature section adjustments */
.feature-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

/* Adjust width for mobile */
.feature-box {
  width: 30%;
  padding: 10px;
}

/* Hide extra features beyond 3 */
.feature-box:nth-child(n+6) {
  display: none;
}

/* Remove unnecessary transformation */
.seller {
  margin-left: 0;
  text-align: center;
}

/* Ensure form fields align properly */
.row1 {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.row1 .col-md-6 {
  flex: 0 0 48%;
  max-width: 48%;
}

.row1 .col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

/* Improve card styling */
.card-header {
  text-align: center;
  font-size: 20px;
  font-weight: bold;
  padding-bottom:10px;
  border-radius: 20px !important;
}

/* Improve form design */
.card {
  width: 330px;
  padding: 20px;
  height: auto;
  border-radius: 8px;
  background: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
  box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
  margin-left: auto;
  margin-right: auto;
}

/* Adjust testimonial text */
.content {
  text-align: center;
  font-size: 13px;
  margin-top: 0px;
}

/* Adjust login button */
.login {
  width: 80px;
  margin: 0 auto;
}

/* Center carousel navigation */
.carousel__nav {
  display: flex;
  justify-content: center;
  padding: 9px 0;
  gap: 1rem;
}

/* Password toggle fix */
#togglePassword {
  margin-top: -12px;
}

/* Limit carousel width */
.carousel {
  margin-top:15px;
  max-width: 313px;
}

/* Hide labels on mobile */
.form-label {
  display: none;
}

/* Ensure placeholder text is visible */
.form-control::placeholder {
  opacity: 1 !important;
}

.glow-on-hover {
  margin-left: -36px;
}

} /* Closing bracket for @media query */


    
</style>


  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ url('/') }}">Home</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Vendor Login
      </li>
    </ul>
  </nav>



  <div>
    <img src="/assets/images/2.png" alt="" height="198.6" class="banner">
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

  <h2 style="transform: translateY(55px);" class="seller">Seller Success Stories</h2>
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

        <div class="card">
          <div class="card-header">
            <h3>Vendor Login Form</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('vendor.login.submit') }}" method="POST">
              @csrf

              <!-- Email -->
              <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Password -->
              <div class="form-group position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                <i class="fas fa-eye password-icon" id="togglePassword"></i>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Remember Me -->
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
              </div>

              <!-- Submit Button -->
              <div class="form-group text-center login">
                <button class="glow-on-hover btn brown-btn" type="submit">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
      var passwordField = document.getElementById('password');
      var type = passwordField.type === "password" ? "text" : "password";
      passwordField.type = type;

      // Toggle eye icon
      this.classList.toggle('fa-eye-slash');
    });
  </script>
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


</body>

</html>