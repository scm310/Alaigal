<!doctype html>
<html lang="en">
<head>
<title>{{ isset($gf) ? $gf->title : 'Admin' }}</title>
<link rel="icon" type="image/png" href="{{ isset($gf) ? asset('storage/app/public/favicon/' . $gf->logo) : '' }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">

    <!-- Add this in your layout file if not included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


	<style>
	body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background-color: black; /* Changed from background image to black color */
    display: flex;
    align-items: center;
    justify-content: center;
}


		.login-wrap {
			background: rgba(255, 255, 255, 0.9);
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
			width: 350px;
			text-align: center;
		}

		/* Adjust placeholder text color */
        ::placeholder { color: black !important; }

		/* Eye icon inside password field */
		.password-container {
			position: relative;
		}

		.password-container .toggle-password {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #333;
		}

		/* Change Sign In button color */
		.btn.submit {
			background-color: #866ec7 !important;
			border-color: #866ec7 !important;
			color: white !important;
			width: 100%;
		}

		.btn.submit:hover {
			background-color: #7559b0 !important;
			border-color: #7559b0 !important;
		}

        .checkbox-wrap{
            margin-right: 181px;


        }

	</style>
</head>
<body>

    <div class="login-wrap">
        @if($header && $header->logo)
            <img src="{{ asset('storage/app/public/logos/' . $header->logo) }}" alt="Logo" style="max-width: 50px; margin-bottom: 10px;">
        @else
            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Default Logo" style="max-width: 50px; margin-bottom: 10px;">
        @endif
    
        <h4 class="mb-3" style="color: black;">Admin Login</h4>
    
        @if ($errors->has('credentials'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ $errors->first('credentials') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    
    


        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email" required>
            </div>
			<div class="form-group password-container">
    <input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>

<!-- Remember Me checkbox below password field -->
<div class="form-group">
    <label class="checkbox-wrap checkbox-primary">
        <input type="checkbox">
        Remember Me

        <span class="checkmark"></span>
    </label>
</div>

            <div class="form-group text-center">
    <button type="submit" class="btn btn-primary submit" style="width: 70%; padding: 8px 0;">Log In</button>
</div>


        </form>
	</div>

	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/popper.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
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
</body>
</html>
