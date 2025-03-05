<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderDetails;
    public $cartItems;

    public function __construct($orderDetails, $cartItems)
    {
        $this->orderDetails = $orderDetails;
        $this->cartItems = $cartItems;
    }

    public function build()
    {
        return $this->subject('Order Confirmation')
                    ->view('emails.order_mail')
                    ->with([
                        'orderDetails' => $this->orderDetails,
                        'cartItems' => $this->cartItems,
                    ]);
    }
}
