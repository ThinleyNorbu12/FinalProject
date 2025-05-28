<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <p style="font-size: 16px; color: #333;">
        Dear <strong>{{ $inspectionRequest->car->owner->name ?? 'Owner' }}</strong>,
    </p>

    <p style="font-size: 16px; color: #333;">
        Your car inspection request for 
        <strong>{{ $inspectionRequest->car->maker }} {{ $inspectionRequest->car->model }}</strong> 
        (Reg. No: <strong>{{ $inspectionRequest->car->registration_no }}</strong>) has been 
        <span style="font-weight: bold; color: {{ $decision === 'approved' ? 'green' : 'red' }};">
            {{ strtoupper($decision) }}
        </span>.
    </p>

    @if($decision === 'approved')
        <p style="font-size: 16px; color: green;">
            🎉 Congratulations! Your car is now ready for the next steps.
        </p>
    @else
        <p style="font-size: 16px; color: #c0392b;">
            ❌ Unfortunately, your car did not pass the inspection.
        </p>
        @if($rejectionReason)
            <p style="font-size: 16px; color: #555;">
                <strong>Reason for rejection:</strong><br>
                <em>{{ $rejectionReason }}</em>
            </p>
        @endif

        <p style="font-size: 16px; color: #333;">
            You can review and resubmit if necessary.
        </p>
    @endif

    <p style="font-size: 16px; color: #333;">
        Thank you,<br>
        <strong>Car Inspection Admin Team</strong>
    </p>
</div>
