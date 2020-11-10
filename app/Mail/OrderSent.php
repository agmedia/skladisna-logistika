<?php

namespace App\Mail;

use App\Models\Back\Orders\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSent extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $pdf_offer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $pdf_offer)
    {
        $this->order = $order;
        $this->pdf_offer = $pdf_offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hvala vam za narudžbu sa ' . config('app.name'))
            ->view('emails.order-sent')
            ->attachData($this->pdf_offer, 'predracun.pdf');
    }
}
