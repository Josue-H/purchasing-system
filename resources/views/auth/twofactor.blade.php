<!-- resources/views/auth/twofactor.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Verificación 2FA</h2>

    <form action="{{ route('2fa.verify') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Código de Verificación:</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Verificar</button>

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
