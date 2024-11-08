@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Producto</h2>
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
<!-- Nombre -->
<div class="mb-3">
    <label for="nombreProducto" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
</div>

<!-- Descripción -->
<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
</div>

<!-- Precio -->
<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" class="form-control" id="precio" name="precio" required>
</div>

<!-- Stock -->
<div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" class="form-control" id="stock" name="stock" required>
</div>

<!-- Imagen -->
<div class="mb-3">
    <label for="imagen" class="form-label">Imagen</label>
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
</div>

        <button type="submit" class="btn btn-primary">Guardar Producto</button>
    </form>
</div>
@endsection
