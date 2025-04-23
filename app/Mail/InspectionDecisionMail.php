<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\InspectionRequest;

class InspectionDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspectionRequest;
    public $decision;

    public function __construct(InspectionRequest $inspectionRequest, $decision)
    {
        $this->inspectionRequest = $inspectionRequest;
        $this->decision = $decision;
    }

    public function build()
    {
        return $this->subject('Car Inspection Decision')
                    ->view('emails.inspection-decision');
    }
}
