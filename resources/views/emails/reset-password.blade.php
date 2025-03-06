<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body style="background-color: #181623;">
    <div style="color: white; padding: 0 40px; margin-top: 20px;">
    <img style="display: inline-block; margin: auto; margin-top: 20px;" 
     src="{{ url('storage/assets/icon.png') }}" 
     alt="Logo">
        <p style="margin-top: 32px;">Hola {{$name}}!</p>
        <p style="margin-top: 22px;">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:</p>
        <a href="{{ $url }}" style="margin-top: 22px; display:inline-block; padding:10px 20px; background-color:#E31221; color:#fff; text-decoration:none; border-radius:5px;">
        Verify account
        </a>
    
        <p style="margin-top: 32px;">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
        <a style="color: #DDCCAA; margin-top: 25px;">{{ $url }}</a>
        <p style="margin-top: 32px;">If you have any problems, please contact us: support@moviequotes.ge</p>
        <p style="margin-top: 22px;">MovieQuotes Crew</p>
    </div>
    <div style="width: 100%; height:10px"></div>
</body>
</html>
