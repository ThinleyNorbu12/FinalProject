<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarOwnerPasswordSetupMail extends Mailable {
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function build() {
        return $this->subject('Set Your Password')
                    ->view('emails.car_owner_password_setup')
                    ->with(['token' => $this->token]);
    }
}
