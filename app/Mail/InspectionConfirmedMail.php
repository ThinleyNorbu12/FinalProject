<?php

namespace App\Mail;

use App\Models\InspectionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspectionRequest;

    // Constructor
    public function __construct(InspectionRequest $inspectionRequest)
    {
        $this->inspectionRequest = $inspectionRequest;
    }

    public function build()
{
    return $this->subject('Inspection Date & Time Confirmed')
                ->view('emails.inspection_confirmed')
                ->with([
                    'owner' => $this->inspectionRequest->car->owner->name,
                    'date' => $this->inspectionRequest->inspection_date,
                    'time' => $this->inspectionRequest->inspection_time,
                    'location' => $this->inspectionRequest->location,
                ]);
}

}
