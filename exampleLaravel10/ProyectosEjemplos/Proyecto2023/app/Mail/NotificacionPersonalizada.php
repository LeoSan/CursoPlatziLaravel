<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionPersonalizada extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario, $asunto, $contenido, $dependencia;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario, $asunto, $contenido)
    {
        $this->usuario = $usuario;
        $this->asunto = $asunto;
        $this->contenido = $contenido ?? 'Has recibido una notificación nueva.';
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
            view: 'notificaciones.notificacion',
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
