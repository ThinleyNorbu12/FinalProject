<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Your Password</title>
</head>
<body>
    <h2>Welcome to Our Service!</h2>
    <p>We received a request to create your account. To set your password, click the link below:</p>

    <p><a href="{{ route('customer.password.set', ['token' => $token]) }}">Set Your Password</a></p>

    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
