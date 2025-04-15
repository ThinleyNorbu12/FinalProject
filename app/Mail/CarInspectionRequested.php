<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\InspectionRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\CarDetail;

class CarInspectionRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $inspectionRequest;

    public function __construct(InspectionRequest $inspectionRequest)
    {
        $this->inspectionRequest = $inspectionRequest;
    }

    public function build()
    {
        return $this->subject('Car Inspection Request Confirmation')
                    ->view('emails.inspection_requested');
    }
}
