<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSetPasswordMail extends Mailable
{
    use SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Set Your Password')
                    ->view('emails.customer.set_password') // Ensure you have this view
                    ->with(['token' => $this->token]);
    }
}
