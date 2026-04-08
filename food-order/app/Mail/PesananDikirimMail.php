<?php

namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PesananDikirimMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Pesanan $pesanan) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesanan Sedang Dikirim - ' . $this->pesanan->kode_pesanan,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pesanan.dikirim',
            with: [
                'pesanan' => $this->pesanan,
            ],
        );
    }
}
