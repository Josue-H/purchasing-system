<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;
    public $detalleFactura;

    public function __construct($factura, $detalleFactura)
    {
        $this->factura = $factura;
        $this->detalleFactura = $detalleFactura;
    }

     public function build()
    {
        $pdf = Pdf::loadView('pdfs.factura', ['factura' => $this->factura, 'detalles' => $this->detalleFactura]);

        return $this->markdown('emails.factura')
            ->subject('Factura de Compra')
            ->attachData($pdf->output(), 'factura.pdf');
    }
}
