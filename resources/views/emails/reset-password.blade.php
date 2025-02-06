<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body style="background-color: #181623;">
    <div style="color: white; padding: 0 40px;">
        <img style="margin: auto; margin-top: 20px;" src="{{ env('APP_URL') . '/storage/assets/Logo.png' }}" alt="Logo">
        <p style="margin-top: 12px;">Hola {{$name}}!</p>
        <p style="margin-top: 12px;">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:</p>
        <a style="margin-top: 12px;" href="{{ $url }}" style="display:inline-block; padding:7px 13px; background-color:#E31221; color:#fff; text-decoration:none; border-radius:4px;">
            Verify account
        </a> 
        <p style="margin-top: 12px;">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
        <a style="color: #DDCCAA; margin-top: 12px;">{{ $url }}</a>
        <p style="margin-top: 12px;">If you have any problems, please contact us: support@moviequotes.ge</p>
        <p style="margin-top: 12px;">MovieQuotes Crew</p>
    </div>
</body>
</html>
