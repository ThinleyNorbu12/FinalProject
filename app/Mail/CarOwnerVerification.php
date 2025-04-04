<?php

namespace App\Mail;

use App\Models\CarOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarOwnerVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $carOwner;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct(CarOwner $carOwner, $token)
    {
        $this->carOwner = $carOwner;
        $this->token = $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Car Owner Account')
                    ->view('emails.carowner-verification');
    }
}