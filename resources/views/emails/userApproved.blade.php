<!DOCTYPE html>
<html>
<head>
    <title>Your account has been approved</title>
</head>
<body>
<p>Hello {{ $user->first_name }} {{ $user->last_name }},</p>

    <p>Your account has been approved. You can now log in to the platform.</p>

    <p><strong>User Details</strong></p>
    <ul>    
    <li>Name: {{ $user->first_name }} {{ $user->last_name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Phone: {{ $user->phone_number }}</li>
        <li>Company: {{ $user->company_name }}</li>
        <li>Website: {{ $user->website }}</li>
        <li>Designation: {{ $user->designation }}</li>
        <li>Location: {{ $user->location }}</li>
    </ul>

    <p><strong>Login Credentials:</strong></p>
    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Password: 1234</li>
    </ul>
    
    <p>You can use the above email and password to log in to both the Member and Vendor portals.</p>

    <p><strong>Login Links:</strong></p>
    <ul>
        <li><a href="https://adm-test.com/memberdirectory">Member Login</a></li>
        <li><a href="https://adm-test.com/vendor/login">Vendor Login</a></li>
    </ul>

    <p>Thank you for being with us!</p>
</body>
</html>

