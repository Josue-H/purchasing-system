<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role  // Especificamos que $role puede ser nulo
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
                // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login'); // Si no está autenticado, redirige al login
        }

        // Verifica si el usuario tiene el rol correcto
        if (Auth::user()->idRol == 1) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirige a otra página
        return redirect()->route('shop.index');
    }
}
