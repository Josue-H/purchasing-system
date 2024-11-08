<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 500px;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
        }


.form-group .input-icon {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #999;
    font-size: 20px;
}

.form-control {
    height: 45px;
    font-size: 16px;
    padding-left: 45px; /* Ajustar el padding para acomodar el ícono */
}

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
            font-size: 20px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Cliente</h2>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de Registro -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Correo Electrónico -->
            <div class="form-group mb-3">
                <label for="nombreUsuario">Correo Electrónico</label>
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" name="nombreUsuario" class="form-control" placeholder="Ingrese su correo electrónico" required>
            </div>

            <!-- Contraseña -->
            <div class="form-group mb-3">
                <label for="contraseña">Contraseña</label>
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="contraseña" class="form-control" placeholder="Ingrese su contraseña" required>
            </div>

            <!-- NIT -->
            <div class="form-group mb-3">
                <label for="idCliente">NIT</label>
                <span class="input-icon"><i class="fas fa-id-card"></i></span>
                <input type="text" name="idCliente" class="form-control" placeholder="Ingrese su NIT" required>
            </div>

            <!-- Nombre -->
            <div class="form-group mb-3">
                <label for="nombreCliente">Nombre</label>
                <span class="input-icon"><i class="fas fa-user"></i></span>
                <input type="text" name="nombreCliente" class="form-control" placeholder="Ingrese su nombre" required>
            </div>

            <!-- Apellido -->
            <div class="form-group mb-3">
                <label for="apellidoCliente">Apellido</label>
                <span class="input-icon"><i class="fas fa-user"></i></span>
                <input type="text" name="apellidoCliente" class="form-control" placeholder="Ingrese su apellido" required>
            </div>

            <!-- Dirección -->
            <div class="form-group mb-3">
                <label for="direccion">Dirección</label>
                <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" name="direccion" class="form-control" placeholder="Ingrese su dirección" required>
            </div>

            <!-- Teléfono -->
            <div class="form-group mb-4">
                <label for="telefono">Teléfono</label>
                <span class="input-icon"><i class="fas fa-phone"></i></span>
                <input type="text" name="telefono" class="form-control" placeholder="Ingrese su teléfono" required>
            </div>

            <!-- Botón de Registro -->
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>
</html>
