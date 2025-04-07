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
    public $verificationUrl;

    public function __construct($carOwner, $verificationUrl)
{
    $this->carOwner = $carOwner;
    $this->verificationUrl = $verificationUrl;
}

public function build()
{
    return $this->view('emails.carowner-verification')
                ->subject('Email Verification Successful')
                ->with([
                    'carOwnerName' => $this->carOwner->name,
                    'verificationUrl' => $this->verificationUrl,
                ]);
}

}
