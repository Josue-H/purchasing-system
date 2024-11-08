<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class BodegueroRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login'); // Si no está autenticado, redirige al login
        }

        // Verifica si el usuario tiene el rol correcto
        if (Auth::user()->idRol == 2) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirige a otra página
        return redirect()->route('403');
    }
}
