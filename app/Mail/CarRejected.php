<?php

namespace App\Mail;

use App\Models\CarDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Mail\CarRejected;


class CarRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $car;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\CarDetail  $car
     * @return void
     */
    public function __construct(CarDetail $car)
    {
        $this->car = $car;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Car Submission Has Been Rejected')
                    ->view('emails.car_rejected');
    }
}
