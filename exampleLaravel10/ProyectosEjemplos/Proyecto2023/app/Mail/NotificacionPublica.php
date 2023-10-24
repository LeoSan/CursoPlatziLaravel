<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionPublica extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto, $contenido, $dependencia, $nombre;

    /**
     * Create a new message instance.
     */
    public function __construct($asunto, $contenido, $nombre = null)
    {
        $this->asunto = $asunto ?? 'test';
        $this->contenido = $contenido;
        $this->nombre = $nombre;
        $this->dependencia = config('app.name');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->asunto,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notificaciones.publica',

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
