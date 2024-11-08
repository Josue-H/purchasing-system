<?php

namespace App\Http\Controllers;

use App\Models\detalleFactura;
use App\Models\Factura;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\FacturaMailable;
use Illuminate\Support\Facades\Mail;


class PedidoController extends Controller
{
    public function index()
    {
        // Obtener todos los pedidos pendientes y cargar las relaciones de cliente y usuario
        $pedidos = Pedido::where('estadoPedido', 'Pendiente')
            ->with(['cliente.usuario'])
            ->get();

        return view('bodeguero.pedidos.index', compact('pedidos'));
    }

    public function show($idPedido)
    {
        $pedido = Pedido::with(['cliente.usuario', 'detallePedido.producto'])->findOrFail($idPedido);

        return view('bodeguero.pedidos.show', compact('pedido'));
    }

    public function generarFactura($idPedido)
    {
        $pedido = Pedido::with('cliente.usuario')->findOrFail($idPedido);

        // Crear la factura
        $factura = Factura::create([
            'idCliente' => $pedido->idCliente,
            'idUsuario' => Auth::id(),
            'fechaFactura' => now(),
            'totalFactura' => $pedido->detallePedido->sum(function ($detalle) {
                return $detalle->cantidad * $detalle->precioUnitario;
            })
        ]);

        // Crear los detalles de la factura
        foreach ($pedido->detallePedido as $detalle) {
            DetalleFactura::create([
                'idFactura' => $factura->idFactura,
                'idProducto' => $detalle->idProducto,
                'cantidad' => $detalle->cantidad,
                'precioUnitario' => $detalle->precioUnitario,
                'descuentoAplicado' => 0,
                'precioFinal' => $detalle->precioUnitario * $detalle->cantidad
            ]);
        }

        // Actualizar el estado del pedido a 'Generado'
        $pedido->estadoPedido = 'Generado';
        $pedido->save();

        // Determinar el correo de destino
        $correo = $pedido->cliente && $pedido->cliente->usuario
            ? $pedido->cliente->usuario->nombreUsuario
            : $pedido->emailEntrega;

        // Enviar el correo con el PDF de la factura
        Mail::to($correo)->send(new FacturaMailable($factura, $factura->detalleFactura));

        return redirect()->route('bodeguero.pedidos.index')->with('success', 'Factura generada y enviada por correo con éxito.');
    }
}
