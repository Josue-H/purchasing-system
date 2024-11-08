<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        $responseMessage = '';

        // Captura explícita del mensaje desde el request
        $incomingMessage = $request->input('message', '');

        // Verifica si el mensaje está vacío y responde en consecuencia
        if (empty($incomingMessage)) {
            return response()->json(['message' => 'No se recibió ningún mensaje.']);
        }

        // Comparación directa del mensaje usando patrones
        if (preg_match('/.*horarios.*/i', $incomingMessage)) {
            $responseMessage = 'Nuestros horarios de atención son de 8:00 a.m. a 8:00 p.m.';
        } elseif (preg_match('/.*envio.*/i', $incomingMessage)) {
            $responseMessage = 'El envío es gratis a todos los departamentos del país.';
        } elseif (preg_match('/.*productos.*disponibles.*/i', $incomingMessage)) {
            $responseMessage = 'Los productos disponibles se muestran en la tienda, puedes también visualizar el stock.';
        } elseif (preg_match('/.*información.*/i', $incomingMessage)) {
            $responseMessage = 'Sí tienes algún inconveniente con un pedido o envío, comunícate al correo jcochojil@miumg.edu.gt o al Teléfono: 47479132.';
        } else {
            $responseMessage = "Lo siento, no entiendo el mensaje: \"$incomingMessage\". ";
            $responseMessage .= 'Puedes contactarnos directamente a través de nuestro WhatsApp ';
            $responseMessage .= '<a href="https://wa.me/+50247479132" target="_blank">aquí</a>. ';
            $responseMessage .= 'Por favor pregunta por nuestros horarios de atención, envio, product disponibles o información.';
        }

        // Retornar la respuesta generada como JSON
        return response()->json(['message' => $responseMessage]);
    }
}
