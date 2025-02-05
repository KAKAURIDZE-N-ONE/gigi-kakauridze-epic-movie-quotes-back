<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Welcome to Our Platform!</h2>
    <p>Click the button below to verify your email address:</p>
    <a href="{{ $verificationUrl }}" style="display:inline-block; padding:10px 20px; background-color:#007bff; color:#fff; text-decoration:none; border-radius:5px;">
        Verify Email
    </a>
    {{ $verificationUrl }}
    <p>If you did not create an account, no further action is required.</p>
</body>
</html>
