@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Crear Nuevo Usuario</h2>
    <form action="{{ route('admin.storeUser') }}" method="POST">
        @csrf

        <!-- Selección de rol al inicio -->
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="" disabled selected>Seleccione un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol }}">{{ $rol }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo de correo electrónico -->
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Correo Electrónico</label>
            <input type="email" name="nombreUsuario" id="nombreUsuario" class="form-control" disabled required>
        </div>

        <!-- Campo de contraseña -->
        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" disabled required>
        </div>

        <!-- Campo de nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" disabled required>
        </div>

        <!-- Campo de apellido -->
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" disabled required>
        </div>

        <!-- Campo de teléfono -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Número de Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" disabled required>
        </div>

        <!-- Campo de dirección (oculto para Bodeguero y Administrador) -->
        <div class="mb-3" id="direccionField">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" disabled>
        </div>

        <!-- Campo de ID Cliente (solo visible para Cliente) -->
        <div class="mb-3" id="idClienteField" style="display: none;">
            <label for="idCliente" class="form-label">NIT</label>
            <input type="text" name="idCliente" id="idCliente" class="form-control" disabled>
        </div>

        <button type="submit" class="btn btn-primary" disabled id="submitButton">Crear Usuario</button>
    </form>
</div>

<!-- Script para activar y ajustar campos según el rol seleccionado -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rolSelect = document.getElementById('rol');
        const fields = document.querySelectorAll('#nombreUsuario, #contraseña, #nombre, #apellido, #telefono, #direccion, #idCliente');
        const direccionField = document.getElementById('direccionField');
        const idClienteField = document.getElementById('idClienteField');
        const submitButton = document.getElementById('submitButton');

        function toggleFields() {
            const selectedRole = rolSelect.value;

            // Activar todos los campos y el botón de envío cuando se selecciona un rol
            fields.forEach(field => field.disabled = false);
            submitButton.disabled = false;

            // Mostrar/ocultar campo de dirección según el rol
            if (selectedRole === 'Bodeguero' || selectedRole === 'Administrador') {
                direccionField.style.display = 'none';
                document.getElementById('direccion').disabled = true;
            } else {
                direccionField.style.display = 'block';
            }

            // Mostrar campo de ID Cliente solo para Cliente
            if (selectedRole === 'Cliente') {
                idClienteField.style.display = 'block';
                document.getElementById('idCliente').disabled = false;
            } else {
                idClienteField.style.display = 'none';
                document.getElementById('idCliente').disabled = true;
            }
        }

        // Ejecutar la función al cambiar el rol y activar solo después de seleccionar un rol
        rolSelect.addEventListener('change', toggleFields);
    });
</script>
@endsection
