<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherEmail extends Mailable
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
        return $this->subject('Your Hotel Voucher')
            ->view('emails.accomodation', $this->data)
            ->attachData($this->pdf, 'hotel-voucher.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
