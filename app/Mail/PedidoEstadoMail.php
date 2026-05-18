<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoEstadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $estado;

    public function __construct($pedido, $estado)
    {
        $this->pedido = $pedido;
        $this->estado = $estado;
    }

    public function build()
    {
        return $this->subject('Actualización de tu pedido')
            ->view('emails.pedido_estado');
    }
}
