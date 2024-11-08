<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoVerificacionMail;
use Carbon\Carbon;


class UsuarioController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register'); // Cargar la vista de registro desde la carpeta auth
    }
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login'); // Cargar la vista de login desde la carpeta auth
    }

    // Manejar el inicio de sesión
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombreUsuario' => 'required',
            'contraseña' => 'required',
        ]);

        $usuario = Usuario::where('nombreUsuario', $request->nombreUsuario)->first();

        if ($usuario && Hash::check($request->contraseña, $usuario->contraseña)) {

            // Generar el código 2FA
            $code = rand(1000, 9999); // Código de 4 dígitos

            // Establecer la expiración para 10 minutos desde ahora
            $codigoExpiracion = Carbon::now()->addMinutes(10);
            // Guardar el código y su expiración en la base de datos
            session(['nombreUsuario' => $usuario->nombreUsuario]);

            $usuario->codigo_2fa = $code;
            $usuario->codigo_2fa_expiracion = $codigoExpiracion;

            $usuario->save();
            // Enviar el código 2FA por correo
            $this->send2FACode($usuario->nombreUsuario, $code);

            // Redirigir al formulario de verificación 2FA
            return redirect()->route('2fa.show');
        } else {
            // Si las credenciales no son válidas, devolver al login con un mensaje de error
            return back()->withErrors(['message' => 'Credenciales incorrectas'])->withInput();
        }
    }
    // Función para enviar el correo con el código de 2FA
    protected function send2FACode($email, $code)
    {
        Mail::to($email)->send(new \App\Mail\CodigoVerificacionMail($code));
    }

    // Mostrar el formulario para ingresar el código 2FA
    public function show2faForm()
    {
        return view('auth.twofactor');
    }

    // Verificar el código 2FA ingresado
    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);
        $nombreUsuario = session('nombreUsuario');
        // Obtener el usuario autenticado
        $usuario = Usuario::where('nombreUsuario', $nombreUsuario)->first();

        // Verificar si el código 2FA es correcto y no ha expirado
        if ($request->code == $usuario->codigo_2fa && Carbon::now()->lessThan($usuario->codigo_2fa_expiracion)) {
            // Eliminar el código 2FA después de que se verifica
            $usuario->codigo_2fa = null;
            $usuario->codigo_2fa_expiracion = null;
            $usuario->save();

            Auth::login($usuario);

            switch ($usuario->idRol) {
                case 1: // Administrador
                    return redirect()->route('admin.dashboard'); // Define esta ruta en tu archivo web.php
                case 3: // Cliente
                    return redirect()->route('shop.index'); // Define esta ruta en tu archivo web.php
                case 2: // Bodeguero
                    return redirect()->route('bodeguero.dashboard'); // Define esta ruta en tu archivo web.php
                default:
                    return redirect()->route('shop.index'); // En caso de que no haya rol, redirigir a home o una ruta por defecto
            }
        } else {
            return back()->withErrors(['message' => 'Código de verificación incorrecto o expirado']);
        }
    }

    // Método para cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Registro de usuarios (clientes)
    public function register(Request $request)
    {
        $request->validate([
            'nombreUsuario' => 'required|unique:Usuario',
            'contraseña' => 'required|min:6',
        ]);

        // Crear el usuario
        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'contraseña' => $request->contraseña, // bcrypt en el modelo
            'idRol' => 3, // Rol de cliente
            'creadoPor' => Auth::id() ?? null,
            'fechaCreacion' => Carbon::now(),
        ]);

        // Llamar directamente al método 'crearCliente' de ClienteController
        $clienteController = new ClienteController();
        return $clienteController->crearCliente($request, $usuario);
    }
}
