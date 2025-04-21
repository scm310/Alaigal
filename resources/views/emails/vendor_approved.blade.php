<!DOCTYPE html>
<html>
<head>
    <title>Vendor Account Approved</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>Your vendor account has been approved! You can log in using the details below:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>  
    <p><a href="{{ $login_url }}">Click here to log in</a></p>
    <p>Thank you!</p>
</body>
</html>
