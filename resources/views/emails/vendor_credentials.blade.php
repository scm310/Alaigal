<!DOCTYPE html>
<html>
<head>
    <title>Vendor Registration Details</title>
</head>
<body>
    <h1>Welcome to Qwiksale, {{ $vendor->vendor_name }}!</h1>
    <p>Your vendor account has been created successfully. Here are your login details:</p>
      
       <p><strong>Login URL: https://qwiksale.syncpg.in/vendor/login</p>
    <p><strong>Email:</strong> {{ $vendor->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please log in to your account and consider changing your password after your first login.</p>
    <p>Thank you!</p>
<p>Best Regards,  </p>
<p>QwikSale Team  </p>
<p>[Website](https://qwiksale.com)  </p>
<p>Email: info@qwiksale.com</p>
</body>
</html>
