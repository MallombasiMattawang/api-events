<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    public $eventMember;

    public function __construct($data)
    {
        $this->eventMember = $data['eventMember'];
        $this->subject = 'Invoice Pembayaran - ' . $this->eventMember->invoice;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail.invoice');
    }
}
