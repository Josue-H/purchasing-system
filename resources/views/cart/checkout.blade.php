<!-- resources/views/cart/checkout.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Carrito de Compras</h2>
    @if(isset($cart) && count($cart) > 0)
        <ul class="list-group mb-3">
            @foreach($cart as $id => $producto)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <img src="{{ asset($producto['imagenUrl']) }}" alt="{{ $producto['nombreProducto'] }}" width="50" height="50" class="me-3">
                    <div>
                        <h6 class="my-0">{{ $producto['nombreProducto'] }}</h6>
                        <small class="text-muted">Cantidad: {{ $producto['cantidad'] }}</small>
                    </div>
                    <span class="text-muted">${{ $producto['precio'] * $producto['cantidad'] }}</span>
                    <div class="btn-group ms-3">
                        <form action="{{ route('cart.add', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">+</button>
                        </form>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">-</button>
                        </form>
                        <form action="{{ route('cart.delete', $id) }}" method="POST" class="ms-1">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="text-end">
            <strong>Total: ${{ array_sum(array_map(function($item) {
                return $item['precio'] * $item['cantidad'];
            }, $cart)) }}</strong>
        </div>
        <form action="{{ route('cart.confirm') }}" method="POST" id="confirmForm">
            @csrf
            <div class="form-group mb-3">
                <label for="idCliente">ID Cliente:</label>
                <input type="text" name="idCliente" id="idCliente" class="form-control"
                value="{{
                     Auth::check() && Auth::user()->cliente ? Auth::user()->cliente->idCliente :
                    (Auth::check() && Auth::user()->administrador ? '' :
                    (Auth::check() && Auth::user()->bodeguero ? '' : ''))
                    }}"
                       readonly required>
            </div>

            <div class="form-group mb-3">
                <label for="nombreEntrega">Nombre de Entrega:</label>
                <input type="text" name="nombreEntrega" id="nombreEntrega" class="form-control"
                       value="{{ Auth::check() && Auth::user()->cliente ? Auth::user()->cliente->nombreCliente : '' }}"
                       {{ Auth::check() ? 'disabled' : '' }} required>
            </div>

            <div class="form-group mb-3">
                <label for="direccionEntrega">Dirección de Entrega:</label>
                <input type="text" name="direccionEntrega" id="direccionEntrega" class="form-control"
                       value="{{ Auth::check() && Auth::user()->cliente ? Auth::user()->cliente->direccion : '' }}"
                       {{ Auth::check() ? 'disabled' : '' }} required>
            </div>

            <div class="form-group mb-3">
                <label for="telefonoEntrega">Número de Teléfono:</label>
                <input type="text" name="telefonoEntrega" id="telefonoEntrega" class="form-control"
                       value="{{ Auth::check() && Auth::user()->cliente ? Auth::user()->cliente->telefono : '' }}"
                       {{ Auth::check() ? 'disabled' : '' }} required>
            </div>

            <div class="form-group mb-3">
                <label for="emailEntrega">Correo Electrónico:</label>
                <input type="email" name="emailEntrega" id="emailEntrega" class="form-control"
                       value="{{ Auth::check() ? Auth::user()->nombreUsuario : '' }}"
                       {{ Auth::check() ? 'disabled' : '' }} required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="enableEdit">
                <label class="form-check-label" for="enableEdit">Editar información</label>
            </div>

            <button type="submit" class="btn btn-primary">Confirmar Compra</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const enableEditCheckbox = document.getElementById('enableEdit');
                const confirmForm = document.getElementById('confirmForm');

                // Verifica que el formulario y el checkbox existan
                if (confirmForm && enableEditCheckbox) {
                    enableEditCheckbox.addEventListener('change', function () {
                        const isEditable = this.checked;
                        document.getElementById('nombreEntrega').disabled = !isEditable;
                        document.getElementById('direccionEntrega').disabled = !isEditable;
                        document.getElementById('telefonoEntrega').disabled = !isEditable;
                        document.getElementById('emailEntrega').disabled = !isEditable;
                    });

                    // Habilitar los campos temporalmente antes de enviar el formulario
                    confirmForm.addEventListener('submit', function () {
                        document.getElementById('nombreEntrega').disabled = false;
                        document.getElementById('direccionEntrega').disabled = false;
                        document.getElementById('telefonoEntrega').disabled = false;
                        document.getElementById('emailEntrega').disabled = false;
                    });
                }
            });
        </script>



    @else
        <p class="text-center">El carrito está vacío.</p>
    @endif
</div>

