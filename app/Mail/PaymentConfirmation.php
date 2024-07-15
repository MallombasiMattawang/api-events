<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $eventMember;

    public function __construct($data)
    {
        $this->eventMember = $data['eventMember'];
        $this->subject = 'Pembayaran Event Berhasil - ' . $this->eventMember->invoice;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail.payment-confirmation');
    }
}
