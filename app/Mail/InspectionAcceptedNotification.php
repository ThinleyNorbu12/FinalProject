<?php

namespace App\Mail;

use App\Models\InspectionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionAcceptedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $adminName; // Declare adminName

    // Accept both the InspectionRequest and adminName
    public function __construct(InspectionRequest $request, $adminName)
    {
        $this->request = $request;
        $this->adminName = $adminName; // Assign adminName to the property
    }

    public function build()
    {
        return $this->subject('Inspection Accepted by Car Owner')
                    ->view('emails.inspection_accepted');
    }
}

