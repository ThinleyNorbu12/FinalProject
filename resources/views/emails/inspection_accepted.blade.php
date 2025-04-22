<!DOCTYPE html>
<html>
<head>
    <title>Inspection Accepted</title>
</head>
<body>
    <h3>Hello {{ $adminName }},</h3> <!-- Display the admin's name -->
    <p>The following inspection request has been accepted by the car owner:</p>

    <ul>
        <li><strong>Car:</strong> {{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</li>
        <li><strong>Registration No:</strong> {{ $request->car->registration_no ?? 'N/A' }}</li>
        <li><strong>Inspection Date:</strong> {{ $request->inspection_date }}</li>
        <li><strong>Inspection Time:</strong> {{ $request->inspection_time }}</li>
        <li><strong>Location:</strong> {{ $request->location }}</li>
    </ul>

    <p>Please proceed with the scheduled inspection.</p>
</body>
</html>
