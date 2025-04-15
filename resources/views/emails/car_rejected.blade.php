<!DOCTYPE html>
<html>
<head>
    <title>Car Rejected</title>
</head>
<body>
    <h2>Hello {{ $car->owner->name ?? 'User' }},</h2>

    <p>We regret to inform you that your car submission has been <strong>rejected</strong>.</p>

    <p><strong>Car Details:</strong></p>
    <ul>
        <li>Maker: {{ $car->maker }}</li>
        <li>Model: {{ $car->model }}</li>
        <li>Registration No: {{ $car->registration_no }}</li>
    </ul>

    <p><strong>Reason for Rejection:</strong></p>
    <p>{{ $car->rejection_reason }}</p>

    <p>If you have any questions, feel free to contact our support team.</p>

    <p>Thank you,<br>The Admin Team</p>
</body>
</html>
