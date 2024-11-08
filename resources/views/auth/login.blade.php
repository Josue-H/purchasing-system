@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="col-lg-5 col-md-8">
            <div class="card bg-light shadow border-0">
                <div class="card-header bg-white text-center">
                    <h3 class="mb-0">Iniciar Sesión</h3>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-user icon-large"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('nombreUsuario') ? ' is-invalid' : '' }}" placeholder="Correo electrónico" type="text" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required autofocus>
                            </div>
                            @if ($errors->has('nombreUsuario'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombreUsuario') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-key icon-large"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('contraseña') ? ' is-invalid' : '' }}" name="contraseña" placeholder="Contraseña" type="password" required>
                            </div>
                            @if ($errors->has('contraseña'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contraseña') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block my-4">Iniciar Sesión</button>
                        </div>
                    </form>

                    <!-- Enlace para registro -->
                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="text-primary">
                            ¿No tienes una cuenta? Regístrate aquí
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
    background-color: #f8f9fa; /* Color de fondo más suave */
}

.card {
    border-radius: 10px; /* Bordes redondeados de la tarjeta */
}

.card-header {
    background-color: #007bff; /* Color del encabezado de la tarjeta */
    color: white;
}

.input-group-text {
    background-color: #007bff;
    color: white;
}
.icon-large {
    font-size: 1.5em; /* Ajusta el tamaño según lo que necesites */
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.form-control {
    border-radius: 5px; /* Bordes más redondeados para los campos */
}

</style>
