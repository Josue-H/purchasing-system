<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Bodeguero;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard()
     {
         return view('admin.index');
     }

     public function createUserForm()
     {
         $roles = ['Cliente', 'Bodeguero', 'Administrador'];
         return view('admin.create_user', compact('roles'));
     }

     public function storeUser(Request $request)
     {
         // Validación del formulario
         $request->validate([
             'nombreUsuario' => 'required|unique:Usuario|max:255',
             'contraseña' => 'required|min:6',
             'rol' => 'required|in:Cliente,Administrador,Bodeguero',
             'nombre' => 'required|max:255',
             'apellido' => 'required|max:255',
             'direccion' => 'nullable|string',
             'telefono' => 'nullable|string|max:20'
         ]);

         // Creación del registro en la tabla Usuario
         $usuario = Usuario::create([
             'nombreUsuario' => $request->nombreUsuario,
             'contraseña' => Hash::make($request->contraseña),
             'idRol' => $request->rol === 'Cliente' ? 3 : ($request->rol === 'Administrador' ? 1 : 2), // Asignación de rol
             'creadoPor' => Auth::user()->idUsuario, // Usuario administrador autenticado
             'fechaCreacion' => now(),
         ]);
         // Creación de registro adicional según el tipo de usuario
         switch ($request->rol) {
             case 'Cliente':
                 Cliente::create([
                     'idUsuario' => $usuario->idUsuario,
                     'nombreCliente' => $request->nombre,
                     'apellidoCliente' => $request->apellido,
                     'direccion' => $request->direccion,
                     'telefono' => $request->telefono,
                 ]);
                 break;

             case 'Administrador':
                 Administrador::create([
                     'idUsuario' => $usuario->idUsuario,
                     'nombreAdministrador' => $request->nombre,
                     'apellidoAdministrador' => $request->apellido,
                     'telefono'=> $request->telefono,
                     'email' => $request->nombreUsuario,
                 ]);
                 break;

             case 'Bodeguero':
                 Bodeguero::create([
                     'idUsuario' => $usuario->idUsuario,
                     'nombreBodeguero' => $request->nombre,
                     'apellidoBodeguero' => $request->apellido,
                     'telefono'=> $request->telefono,
                     'email' => $request->nombreUsuario,
                 ]);
                 break;
         }

         return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente');
     }

     private function getRoleId($roleName)
     {
         switch ($roleName) {
             case 'Cliente':
                 return 3;
             case 'Bodeguero':
                 return 2;
             case 'Administrador':
                 return 1;
             default:
                 return 3;
         }
        }
}
