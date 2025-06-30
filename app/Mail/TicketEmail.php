<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $data;

    public function __construct($pdf, $data)
    {
        $this->pdf = $pdf;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Your Ticket Booking')
            ->view('emails.ticket', $this->data)
            ->attachData($this->pdf, 'ticket.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
