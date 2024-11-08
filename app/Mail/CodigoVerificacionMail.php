<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;

    /**
     * Crea una nueva instancia del correo.
     *
     * @param string $codigo - El código de verificación 2FA
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Construye el correo.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('auth.code') // Vista donde estará el cuerpo del correo
                    ->subject('Código de Verificación 2FA')  // Asunto del correo
                    ->with(['codigo' => $this->codigo]);  // Enviar el código a la vista
    }
}
