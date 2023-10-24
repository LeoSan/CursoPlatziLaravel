<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario, $asunto, $tipo, $dependencia, $extras;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario, $tipo, $asunto = null, $extras = null)
    {
        $this->usuario = $usuario;
        $this->asunto = $asunto ?? $this->getSubject($tipo);
        $this->tipo = $tipo;
        $this->dependencia = config('app.name');
        $this->extras = $extras ?? [];
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
            view: 'notificaciones.catalogo.' . $this->tipo ?? 'test',
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

    public function getSubject()
    {
        switch ($this->tipo) {
            case 'resetPassword':
                return 'Solicitud para restablecer contraseña';
            case 'creacionCuenta':
                return 'Notificación de prueba';
            case 'turnarCaso':
                return 'Ha sido asignado a un caso para atención';
            case 'rechazoAnalista':
            case 'rechazoRegional':
            case 'rechazoProcurador':
                return 'Ha recibido de vuelta un caso para atención';
            case 'infoPendiente':
                return 'Información solicitada para el expediente '. $this->extras['numero_expediente'];
            case 'cargaInformeDenuncia':
                return 'Se ha cargado el informe de la denuncia con expediente' . $this->extras['numero_expediente'] . 'para revisión';
            case 'cargaInformeDenunciaComentarios':
                return 'Se ha revisado el informe de la denuncia con expediente' . $this->extras['numero_expediente'];
            default:
                return 'Notificación';
        }
    }
}
