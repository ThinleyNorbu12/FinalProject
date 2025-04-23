<!DOCTYPE html>
<html>
<head>
    <title>Inspection Decision</title>
</head>
<body>
    <h2>Dear {{ $inspectionRequest->car->owner->name ?? 'Owner' }},</h2>

    <p>Your car inspection request for <strong>{{ $inspectionRequest->car->maker }} {{ $inspectionRequest->car->model }}</strong> (Reg. No: {{ $inspectionRequest->car->registration_no }}) has been <strong>{{ $decision }}</strong>.</p>

    @if($decision === 'approved')
        <p>Congratulations! Your car is now ready for the next steps.</p>
    @else
        <p>Unfortunately, your car did not pass the inspection. You can review and resubmit if necessary.</p>
    @endif

    <p>Thank you,<br>Car Inspection Admin Team</p>
</body>
</html>
