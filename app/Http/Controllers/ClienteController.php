<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Crear el cliente asociado al usuario recién creado
    public function crearCliente(Request $request, $usuario)
    {
        Cliente::create([
            'idCliente' => $request->idCliente,
            'idUsuario' => $usuario->idUsuario,
            'nombreCliente' => $request->nombreCliente,
            'apellidoCliente' => $request->apellidoCliente,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'esInvitado' => false,
        ]);

        return response()->json(['message' => 'Cliente registrado exitosamente']);
    }
}
