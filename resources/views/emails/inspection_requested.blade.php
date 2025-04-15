<h2>Hello {{ $inspectionRequest->car->owner->name }},</h2>

<p>Your car inspection has been scheduled.</p>

<ul>
    <li><strong>Car:</strong> {{ $inspectionRequest->car->maker }} {{ $inspectionRequest->car->model }}</li>
    <li><strong>Registration No:</strong> {{ $inspectionRequest->car->registration_no }}</li>
    <li><strong>Date:</strong> {{ $inspectionRequest->inspection_date }}</li>
    <li><strong>Time:</strong> {{ $inspectionRequest->inspection_time }}</li>
    <li><strong>Location:</strong> {{ $inspectionRequest->location }}</li>
</ul>

<p><em>Note: Each car inspection typically takes around 1 hour.</em></p>

<p>Thank you!</p>
