@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Producto</h2>
    <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombreProducto" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" value="{{ $producto->nombreProducto }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" value="{{ $producto->precio }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $producto->stock }}" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
