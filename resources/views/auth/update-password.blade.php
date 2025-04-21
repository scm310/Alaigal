@extends('memberlayout.navbar')

@section('content')


<style>

.container-wrapper {
        width: 95%;
        max-width: 500px;
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

    .container{
        margin-top: 9px;
    }
    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .card {
        border-radius: 10px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    @media (max-width: 768px) {
        .btn-responsive {
            width: auto; /* Adjust width based on content */
            display: inline-block; /* Ensures it stays in one line */
        }
    }

    @media (max-width: 576px) {
    .container-wrapper {
        padding: 15px;
        margin-top: 20px !important; /* Adjust this value to push the form down */
    }
}

</style>



<div class="container-wrapper mt-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="text-align:center;" role="alert" id="success-alert">
        {{ session('success') }}

    </div>

    <!-- JavaScript to Auto-Fade the Message -->
    <script>
        // Automatically fade out the alert after 5 seconds
        setTimeout(function () {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.style.display = 'none', 200); // Ensure it disappears fully
            }
        }, 2000);  // 5 seconds
    </script>
    @endif


    <div class="card shadow-lg p-4" style="background-color: #d3cce3; border-radius: 10px;">
        <!-- Header -->
        <div class="header">Update Password </div>


        <form method="POST" action="{{ route('update-password.submit') }}">
            @csrf

            <!-- Current Password -->
            <div class="form-group mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <div class="input-group">
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-current-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                @error('current_password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="form-group mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-group">
                    <input type="password" name="new_password" id="new_password"
                           class="form-control" required minlength="8" maxlength="8"
                           pattern=".{8,8}" title="Password must be exactly 8 characters"
                           oninput="validatePassword(this)">
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-new-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div id="password-error" class="text-danger mt-1"></div>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <div class="input-group">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                           class="form-control" required minlength="8">
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-new-password-confirmation" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                @if ($errors->has('new_password'))
                <div class="text-danger mt-1">{{ $errors->first('new_password') }}</div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-responsive">Update Password</button>
            </div>
        </form>
    </div>
</div>






<script>
    document.getElementById('toggle-current-password').addEventListener('click', function() {
        var passwordField = document.getElementById('current_password');
        var icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('toggle-new-password').addEventListener('click', function() {
        var passwordField = document.getElementById('new_password');
        var icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

       // Function to validate password length and show error message
       function validatePassword(input) {
        let errorMessage = "Password must be exactly 8 characters";
        let errorDiv = document.getElementById("password-error");

        if (input.value.length !== 8) {
            input.setCustomValidity(errorMessage);
            errorDiv.innerText = errorMessage;
        } else {
            input.setCustomValidity("");
            errorDiv.innerText = "";
        }
    }

    document.getElementById('toggle-new-password-confirmation').addEventListener('click', function() {
        var passwordField = document.getElementById('new_password_confirmation');
        var icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>


@endsection
