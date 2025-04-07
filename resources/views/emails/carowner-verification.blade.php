{{-- resources/views/emails/carowner-verification.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Car Owner Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a69bd;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #4a69bd;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Our Car Rental Service</h1>
    </div>
    <div class="content">
        <p>Hello {{ $carOwner->name }},</p>
        
        <p>Thank you for registering as a car owner on our platform. To complete your registration and set up your password, please click the button below:</p>
        
        <p style="text-align: center;">
            <a href="{{ route('carowner.verify', $token) }}" class="button">Set Your Password</a>
        </p>
        
        <p>If the button doesn't work, you can copy and paste this URL into your browser:</p>
        <p>{{ route('carowner.verify', $token) }}</p>
        
        <p>This link will expire in 24 hours for security reasons.</p>
        
        <p>Once your account is verified, you'll be able to list your cars for rental and manage your bookings through our platform.</p>
        
        <p>If you did not create an account, no further action is required.</p>
        
        <p>Best regards,<br>
        The Car Rental Team</p>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Hello, {{ $carOwnerName }}</p>

    <p>Your email has been successfully verified. Please click the button below to set your password:</p>

    <a href="{{ $verificationUrl }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Set Your Password
    </a>

    <p>If you did not request this, please ignore this email.</p>
</body>
</html>


