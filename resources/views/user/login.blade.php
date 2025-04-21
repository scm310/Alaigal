<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>TIEPMD</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/admin_assets/assets/css/demo.css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/css/pages/page-auth.css" />
    <script src="/admin_assets/assets/vendor/js/helpers.js"></script>
    <script src="/admin_assets/assets/js/config.js"></script>
    <style>
    
    
    
    .brown-btn {
    background-color: rgb(168, 118, 118); /* brown color */
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-transform: capitalize;
}

.brown-btn:hover {
 background-color: #9055fd;
}

        /* Background styling */
        body {
            margin: 0;
            padding: 0;
            background: url('/admin_assets/assets/img/background3.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            color: #fff;
        }

        .navbar .logo img {
            background-color: #fff;
            border-radius: 25px;
        }

        .container {
            display: flex;
            flex: 1;
            width: 100%;
            height: calc(100vh - 60px); /* Subtract the height of the navbar */
            background: transparent;
        }

        .left-section, .right-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #fff;
            box-sizing: border-box;
        }

        .header-text {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-text h2 {
            text-shadow: 2px 2px #f10b0b;
            font-size: 2.5em;
            margin: 0;
        }

        .transparent-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 80%;
            backdrop-filter: blur(10px);
        }

        .transparent-card p {
            font-size: 1.2em;
            margin: 0;
        }

        .buttons {
            margin-top: 20px;
        }

        .main-button {
            text-align: center;
        }

        .main-button form button {
            border-radius: 25px;
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        .right-sections {
            backdrop-filter: blur(10px); /* Adds a slight blur effect */
        }

        .authentication-inner {
            background-color: rgba(255, 255, 255, 0.15); /* Transparent background */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 420px;
            max-height: 80vh;
            overflow: auto; /* Add scrolling if content overflows */
        }

        .app-brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .app-brand-text {
            color: #fff; /* Set text color to white */
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .app-brand-text img {
            margin-right: 10px;
        }

        h4 {
            color: #fff; /* Set text color to white */
            text-align: center;
            font-weight: 400;
            margin-bottom: 20px;
        }

        .form-control {
            color: #fff !important; /* Set text color to white */
            background-color: transparent !important; /* Ensure background remains transparent */
            border: 1px solid rgba(255, 255, 255, 0.5) !important; /* Border color */
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important; /* Set placeholder text color to white */
        }

        .form-control:focus {
            color: #fff !important; /* Set text color on focus */
            background-color: transparent !important; /* Ensure background remains transparent */
        }

        /* Styles for autofilled fields */
        .form-control:-webkit-autofill {
            color: #fff !important;
            background-color: transparent !important;
        }

        .form-control:-webkit-autofill::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .form-control:-moz-autofill {
            color: #fff !important;
            background-color: transparent !important;
        }

        .form-control:-moz-autofill::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7); /* Set text color to white */
        }

        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-primary:hover {
            background-color: #3f3dbb;
            border-color: #3f3dbb;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.7); /* Set text color to white */
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .top-50 {
            top: 50%;
        }

        .end-0 {
            right: 0;
        }

        .translate-middle-y {
            transform: translateY(-50%);
        }

        .pe-2 {
            padding-right: 0.5rem;
        }

        /* Mobile Responsive Styles */
@media (max-width: 768px) {
    .navbar {
        padding: 10px 20px;
    }

    .header-text h2 {
        font-size: 1.8em; /* Adjust font size for smaller screens */
    }

    .container {
        flex-direction: column; /* Stack sections vertically */
    }

    .left-section, .right-section {
        width: 100%; /* Full width */
        padding: 10px; /* Adjust padding */
    }

    .authentication-inner {
        padding: 15px; /* Adjust padding for the authentication box */
        width: 90%; /* More width for smaller screens */
        max-width: 90%; /* Prevent overflow */
    }

    .form-control {
        font-size: 1em; /* Adjust font size for inputs */
    }

    .btn-primary {
        width: 100%; /* Full width button */
    }
}

/* Additional adjustments for very small screens */
@media (max-width: 480px) {
    .navbar {
        padding: 5px 10px;
    }

    .header-text h2 {
        font-size: 1.5em; /* Further reduce font size */
    }

    .authentication-inner {
        max-height: 70vh; /* Limit height on very small screens */
    }

    h4 {
        font-size: 1.5em; /* Smaller heading size */
    }

    .form-control {
        padding: 10px; /* Adjust input padding */
    }
}

    </style>

</head>
<body>
    <div class="navbar">
        <div class="logo">
            <!--<a href="/login" class="logo">-->
            <!--    <img src="/admin_assets/assets/img/autoforge_logo.png" alt="Auto-Forge Logo">-->
            <!--</a>-->
        </div>
    </div>

    <div class="container">
        <div class="left-section">
            <div class="header-text">
                <!--<h2 style="color: #fff!important;font-size: 50px;">Project Control System</h2>-->
            </div>
        </div>
        <div class="right-section">
            <div class="authentication-inner right-sections">
                <div class="card-body mt-2">
                    <h4>Welcome <small>To</small> TIEPMD </h4>

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong></strong> Invalid email or password
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form id="formAuthentication" class="mt-2 mb-3" action="{{ route('login.submit') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus required />
                        </div>
                        <div class="mb-3 position-relative">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer position-absolute top-50 end-0 translate-middle-y pe-2" id="togglePassword" title="Click here to show password">
                                    <i class="mdi mdi-eye-off-outline"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" />
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <center>
                               <button class="btn brown-btn d-grid w-40" style="text-transform: capitalize;" type="submit">Login</button>

                            </center>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="/admin_assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/admin_assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="/admin_assets/assets/vendor/js/bootstrap.js"></script>
    <script src="/admin_assets/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="/admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/admin_assets/assets/vendor/js/menu.js"></script>
    <script src="/admin_assets/assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript">
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('mdi-eye-off-outline');
                icon.classList.add('mdi-eye-outline');
                this.title = 'Click here to hide password'; // Update title
            } else {
                passwordField.type = 'password';
                icon.classList.remove('mdi-eye-outline');
                icon.classList.add('mdi-eye-off-outline');
                this.title = 'Click here to show password'; // Update title
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            var emailField = document.getElementById('email');
            var passwordField = document.getElementById('password');
            var rememberMeCheckbox = document.getElementById('rememberMe');
            
            // Load saved email and password from local storage
            var savedEmail = localStorage.getItem('savedEmail');
            var savedPassword = localStorage.getItem('savedPassword');
            
            if (savedEmail) {
                emailField.value = savedEmail;
                rememberMeCheckbox.checked = true; // Auto-check remember me if email is saved
            }

            if (savedPassword) {
                passwordField.value = savedPassword;
            }

            // Save email and password to local storage on form submit if "Remember Me" is checked
            document.getElementById('formAuthentication').addEventListener('submit', function() {
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem('savedEmail', emailField.value);
                    localStorage.setItem('savedPassword', passwordField.value);
                } else {
                    localStorage.removeItem('savedEmail');
                    localStorage.removeItem('savedPassword');
                }
            });

            // Set fields to readonly temporarily to prevent autofill
            emailField.setAttribute('readonly', true);
            passwordField.setAttribute('readonly', true);
            
            // Remove readonly attribute after a delay
            setTimeout(function() {
                emailField.removeAttribute('readonly');
                passwordField.removeAttribute('readonly');
            }, 500);
        });
    </script>
</body>
</html>
