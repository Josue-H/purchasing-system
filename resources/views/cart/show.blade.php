<!-- resources/views/cart/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Tu Carrito de Compras</h2>

        @if(session('cart') && count(session('cart')) > 0)
            <ul class="list-group mb-3">
                @foreach(session('cart') as $id => $producto)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="my-0">{{ $producto['nombreProducto'] }}</h6>
                            <small class="text-muted">Cantidad: {{ $producto['cantidad'] }}</small>
                        </div>
                        <span class="text-muted">${{ $producto['precio'] * $producto['cantidad'] }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="text-end">
                <strong>Total: ${{ array_sum(array_map(function($item) {
                    return $item['precio'] * $item['cantidad'];
                }, session('cart'))) }}</strong>
            </div>
            <div class="mt-3">
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceder al Pago</a>
            </div>
        @else
            <p>El carrito está vacío.</p>
        @endif
    </div>
@endsection
