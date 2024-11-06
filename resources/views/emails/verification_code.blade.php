<!-- resources/views/emails/verification_code.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .content {
            font-size: 16px;
            color: #555555;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="content">
            <p>Hello,</p>
            <p>Your verification code is:</p>
            <h2>{{ $code }}</h2>
            <p>Please use this code to verify your account. If you did not request this, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>Wazefni Team</p>
        </div>
    </div>
</body>

</html>
