<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{

    use Queueable, SerializesModels;

    public $mess;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mess)
    {
        $this->mess = $mess;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mess->subject)
                    ->from($this->mess->sender)
                    ->view('emails.message')
                    ->with(['mess' => $this->mess]);
    }
}
