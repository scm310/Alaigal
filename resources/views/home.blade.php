<!doctype html>
<html lang="en">
<head>
<link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
<title>{{ isset($gf) ? $gf->title : 'Admin' }}</title>
<link rel="icon" type="image/png" href="{{ isset($gf) ? asset('storage/app/public/favicon/' . $gf->logo) : '' }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">

    <style>
        /* Full-page background carousel */
        .carousel-section {
            position: absolute;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: -1; /* Send it to the background */
        }

        .carousel-inner img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        /* Logo & title section (top left) */
        .header-logo {
            position: absolute;
            top: 60px;
            left: 20px;
            display: flex;
            align-items: center;
            color: white;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .header-logo img {
            max-width: 100px;
            margin-left: 50px;
        }

        .login-wrap {
    position: absolute;
    top: 50%;
    left: 80%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.15); /* Transparent white */
    backdrop-filter: blur(10px); /* Frosted glass effect */
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 400px;
    height:580px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

        .logo-section {
            margin-top: 40px; /* Added margin-top for spacing */
        }

        /* Styling for password toggle icon */
        .password-field-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #080808;
            font-size: 16px;
        }

        .submit {
            width: 150px; /* Adjust the width as needed */
            margin: 0 auto; /* Center the button */
            display: inline-block; /* Ensure the button is treated as inline block */
        }



        /* Bottom-left description text */
        .bottom-left-text {
            position: absolute;
            left: 20px;
            bottom: 18px;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            max-width: 800px; /* Limit the width to prevent the text from stretching too far */
            line-height: 1.4;
        }

        .top-text {
            font-size: 1.2rem;
            color: black;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Logo Section Above the Form */
        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .logo-section img {
            max-width: 40px; /* Small logo size */
            margin-right: 10px;
            /* Aligns to the left */
            border-radius: 10px;
        }

        .logo-section p {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logo-section small {
            font-size: 1rem;
            color: black;
            display: block;
            text-align: center;
            margin-top: 5px;
        }

        .description-text {
            font-size: 1.1rem;
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group .submit, .form-group .btn-register {
    /* Makes both buttons stretch to the same width */
    display: block; /* Ensures the button takes up the entire line */
}


.btn-register {
    width: 200px;
    margin-left: 71px;
}

/* Hide in mobile view */
@media (max-width: 768px) {
    .btn-register {
        display: none;
    }
}


/* Style for terms and privacy policy text */
.terms-text {
    font-size: 0.8rem;  /* Small text size */
    color: #555;        /* Light grey color */
}

.terms-text a {
    color: #007bff;  /* Blue color for links */
    text-decoration: none;  /* Remove underline */
}

.terms-text a:hover {
    text-decoration: underline;  /* Underline on hover */
}

/* Style for the points list */
.points-list {
    display: flex; /* Arrange points in a row */
    gap: 20px; /* Space between the points */
    align-items: center; /* Align the items vertically */
    margin-top: 10px; /* Space between text and points */
}

.point {
    display: flex;
    align-items: center;
    font-size: 1rem; /* Adjust font size */
    color: #fff; /* Color for text */
}

.point i {
    color: #28a745; /* Green color for checkmark */
    margin-right: 10px; /* Space between icon and text */
}

.point span {
    font-weight: normal; /* Regular font weight for the text */
}



        /* Mobile view adjustments */
        @media (max-width: 768px) {
            /* Remove top styles for mobile */
            .header-logo {
                position: static;
                font-size: 1rem;
                margin-left: 0;
            }

            .header-logo img {
                max-width: 40px;
            }

            /* Adjust login container to fit the screen */
            .login-wrap {
                position: relative;
                top: 20px;
                left: auto;
                transform: none;
                width: 90%;
                padding: 10px;
                min-height: auto; /* Remove min-height for smaller screens */
            }

            /* Adjust description text */
            .description-text {
                font-size: 1rem;
                text-align: center;
                margin-bottom: 10px;
            }

            /* Adjust submit button */

            /* Remove extra left padding for smaller screens */
            .logo-section {
                margin-top: 10px;
                justify-content: center;
                text-align: center;
            }



.description-text {
            font-size: 0.8rem;
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }

        }

        @media (max-width: 768px) {
    .mobile-hidden {
        display: none;
    }
}

@media (max-width: 768px) {
    .responsive-text {
        font-size: 11px;
    }

    .points-list .point i {
        font-size: 1em;
    }

    .bottom-left-text {
    position: absolute;
    left: 12px;
    bottom:53px;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
    max-width: 800px;
    line-height: 1.4;
}
}

@media (max-width: 576px) {
    .btn-register {
        margin-left: 60px !important;
    }
}
/* Reduce input field size */
.form-control {
    padding: 5px 8px;
    font-size: 14px;
    height: 32px;
}

/* Reduce button size */
.btn {
    padding: 5px 10px;
    font-size: 14px;
}
.btn-primary {
    margin-top: 20px;
}

/* Reduce table font size */
.table {
    font-size: 14px;
}



    </style>
</head>
<body>

    <!-- Header Logo & Title -->
    <div class="header-logo mobile-hidden">
    @if(isset($headerSettings) && $headerSettings->logo)
        <img src="{{ asset('storage/app/public/logos/' . $headerSettings->logo) }}" alt="Logo">
    @else
        {{-- <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo"> --}}
    @endif
</div>



    <!-- Full Background Banner -->
    <div class="carousel-section">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2000">
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/app/public/banners/' . basename($banner->banner_image)) }}" alt="Banner">
                    </div>
                @endforeach
            </div>
            <!-- Left and Right Controls (Arrows) -->
            <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a> -->
        </div>
    </div>



    <!-- Login Section -->
    <div class="container">
    <div class="login-wrap mx-auto">
        <!-- Logo and Welcome Text Above the Form -->
        <div class="logo-section" style="margin-top: 80px; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; text-align: left;">
            @if(isset($headerSettings) && $headerSettings->logo)
                <img src="{{ asset('storage/app/public/logos/' . $headerSettings->logo) }}" alt="Logo">
            @else
                {{-- <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo"> --}}
            @endif
            <span>{{ $headerSettings->title ?? '' }}</span>
        </div>

        <!-- Description Text Below the Welcome -->
        <p class="description-text" style="font-style: italic; text-align: left; font-weight: bold;">
            Manage your membership with ease and access your account seamlessly.
        </p>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            @if ($errors->any())
                Swal.fire({
                    title: 'Oops...',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#866ec7',  // Button background color
                    width: '300px',
                    customClass: {
                        popup: 'small-swal',
                   
                    }
                });
            @endif
        </script>
        
        
        

<style>
/* Reduce SweetAlert text size */
.small-swal {
    font-size: 14px !important;
}
                  
</style>



        <!-- Login Form -->
        <form action="{{ route('member.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
            </div>
<!-- Password Input Field with Eye Icon -->
<div class="form-group password-field-container">
    <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
    <span toggle="#password-field" class="fa fa-fw fa-eye toggle-password"></span>
</div>

<!-- jQuery Script for Toggle Password Visibility -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".toggle-password").click(function () {
            var input = $("#password-field");
            var icon = $(this);

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
</script>

            <!-- Remember Me Checkbox -->
            <div class="d-flex justify-content-between align-items-center">
                <label class="checkbox-wrap checkbox-primary mb-0">
                    <span class="checkmark"></span>
                    <input type="checkbox">
                    Remember Me


                </label>
            </div>

            <!-- Sign In Button -->
            <div class="form-group">
            <button type="submit" class="form-control btn submit" style="background-color: #866ec7; color: #fff;     width: 200px;">Sign In</button>

</div>

<!-- OR Text and Register Button -->
<div class="text-center">
    <p class="or-text" style="font-size: 1rem; font-weight: bold;">OR</p>
</div>
<div class="form-group text-center">
    <a href="{{ route('memberregister') }}" class="btn btn-outline-dark btn-register">Request To Register</a>
</div>

<!-- Terms and Privacy Policy Text -->
<div class="form-group text-center" id="terms-section">
    <small class="terms-text">
        By continuing, you agree to our
        <a href="{{ route('privacy_policy') }}" target="_blank" class="terms-link">Privacy Policy.</a>
    </small>
</div>








        </form>
    </div>
</div>


    <!-- Bottom-left description text -->
    <div class="bottom-left-text">
    <p class="responsive-text">Welcome to the Member Management Application, your gateway to manage all your membership and user data with ease.</p>

    <!-- Points with Checkmark Icons -->
    <div class="points-list">
        <div class="point">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            <span class="responsive-text">Easy Membership Management</span>
        </div>
        <div class="point">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            <span class="responsive-text">Seamless User Experience</span>
        </div>
        <div class="point">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            <span class="responsive-text">Comprehensive Data Access</span>
        </div>
    </div>
</div>


    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
    <script>
    document.querySelectorAll('.terms-link').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('terms-section').style.display = 'none';
        });
    });
</script>


</body>
</html>
