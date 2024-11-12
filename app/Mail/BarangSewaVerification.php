<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BarangSewaVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $Url;
    /**
     * Create a new message instance.
     */
    public function __construct($Url)
    {
        $this->Url = $Url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Barang Sewa Verification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.seafoodverification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
