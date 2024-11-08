@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lista de Pedidos Pendientes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Nombre de Usuario</th>
                <th>Email para entrega</th>
                <th>Fecha Pedido</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->idPedido }}</td>
                    <td>{{ $pedido->cliente->nombreCliente }} {{$pedido->cliente->apellidoCliente}}</td>
                    <td>{{ $pedido->cliente->usuario->nombreUsuario ?? 'Sin Usuario' }}</td>
                    <td>{{ $pedido->emailEntrega }}</td>
                    <td>{{ $pedido->fechaPedido }}</td>
                    <td>{{ $pedido->estadoPedido }}</td>
                    <td>
                        <a href="{{ route('bodeguero.pedidos.show', $pedido->idPedido) }}" class="btn btn-info">Ver Detalle</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
