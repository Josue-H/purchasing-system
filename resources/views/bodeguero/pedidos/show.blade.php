@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Detalle del Pedido #{{ $pedido->idPedido }}</h2>

    <div class="mb-3">
        <strong>Cliente:</strong> {{ $pedido->cliente->nombreCliente ?? 'Invitado' }}<br>
        <strong>Fecha Pedido:</strong> {{ $pedido->fechaPedido }}<br>
        <strong>Estado:</strong> {{ $pedido->estadoPedido }}
    </div>

    <h4>Productos en el Pedido</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detallePedido as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombreProducto }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Q{{ $detalle->precioUnitario }}</td>
                    <td>Q{{ $detalle->precioUnitario * $detalle->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
                <!-- Mostrar el botón solo si el estado es "Pendiente" -->
        @if($pedido->estadoPedido === 'Pendiente')
        <form action="{{ route('bodeguero.pedidos.generarFactura', $pedido->idPedido) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Generar Factura y Marcar como Generado</button>
        </form>
    @else
        <button class="btn btn-secondary" disabled>Factura Generada</button>
    @endif
    </div>
</div>
@endsection
