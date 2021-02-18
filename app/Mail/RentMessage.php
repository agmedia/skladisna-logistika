<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RentMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $rent;


    /**
     * Create a new message instance.
     *
     * @param $contact
     */
    public function __construct($rent)
    {
        $this->rent = $rent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $type = $this->rent['type'] ? $this->rent['type'] : '';

        return $this->subject('Upit za najam: ' . $this->rent['oib'] . ', ' . $type)->view('emails.rent-message')->with(['rent' => $this->rent]);
    }
}
