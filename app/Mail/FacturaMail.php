<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Ingreso;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ingreso;

    /**
     * Create a new message instance.
     */
    public function __construct(Ingreso $ingreso)
    {
        $this->ingreso = $ingreso;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comprobante de pago Cooperadora EEt3107',    
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.factura',
            with: [
                'ingreso' => $this->ingreso,
            ],
        );
    }

    /**
     * Get the attachments for the message
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
