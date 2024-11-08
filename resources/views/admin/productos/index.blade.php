@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Productos</h2>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Crear Producto</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->idProducto }}</td>
                    <td>{{ $producto->nombreProducto }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->idProducto) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->idProducto) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
