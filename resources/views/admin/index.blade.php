@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Panel de Administración</h1>
    <ul class="list-group mt-3">
        <li class="list-group-item">
            <a href="{{ route('shop.index') }}">Ir a la Tienda</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('admin.createUser') }}">Crear Usuarios</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('admin.products') }}">CRUD de Productos</a>
        </li>
    </ul>
</div>
@endsection
