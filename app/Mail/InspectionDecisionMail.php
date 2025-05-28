<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspectionRequest;
    public $decision;
    public $rejectionReason;

    public function __construct($inspectionRequest, $decision, $rejectionReason = null)
    {
        $this->inspectionRequest = $inspectionRequest;
        $this->decision = $decision;
        $this->rejectionReason = $rejectionReason;
    }

    public function build()
    {
        return $this->subject('Car Inspection Decision - ' . ucfirst($this->decision))
                    ->view('emails.inspection-decision')
                    ->with([
                        'inspectionRequest' => $this->inspectionRequest,
                        'decision' => $this->decision,
                        'rejectionReason' => $this->rejectionReason
                    ]);
    }
}