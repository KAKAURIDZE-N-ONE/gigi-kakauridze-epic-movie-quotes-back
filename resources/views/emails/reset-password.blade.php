<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body style="background-color: #181623; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #181623; padding: 0;">
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #181623; color: white; border-radius: 10px; overflow: hidden;">
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <img src="{{ url('storage/assets/icon.png') }}" alt="Logo" style="display: block; margin: 0 auto; margin-top: 30px; padding: 0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 40px; margin-top: 20px;">
                            <p style="margin-top: 32px;">Hola {{$name}}!</p>
                            <p style="margin-top: 22px;">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:</p>
                            <a href="{{ $url }}" style="margin-top: 22px; display:inline-block; padding:10px 20px; background-color:#E31221; color:#fff; text-decoration:none; border-radius:5px;">
                            Verify account
                            </a>
                        
                            <p style="margin-top: 32px;">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
                            <a style="color: #DDCCAA; margin-top: 25px;">{{ $url }}</a>
                            <p style="margin-top: 32px;">If you have any problems, please contact us: support@moviequotes.ge</p>
                            <p style="margin-top: 22px;">MovieQuotes Crew</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="width: 100%; height: 10px;"></div>
</body>
</html>
