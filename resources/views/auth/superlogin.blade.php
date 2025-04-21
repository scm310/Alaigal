<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>qwiksale Super Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('{{ asset('assets/superadmin/loginbg.jpeg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.5); /* More transparent background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
    width: 40%; /* Adjusted width to a more balanced size */
    padding: 10px; /* Reduced size */
    font-size: 14px; /* Reduced font size */
    background-color: #A87676; /* Updated background color */
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
    display: block;
    margin: 0 auto; /* Centers the button */
}


        button[type="submit"]:hover {
            background-color: #8f5f5f; /* Darker shade for hover */
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        .login-footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>qwiksale-Super Admin Login</h2>

        <form method="POST" action="{{ route('superadmin.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>

        <div class="login-footer">
            <p>Forgot your password? <a href="#">Click here</a></p>
        </div>
    </div>

</body>
</html>
