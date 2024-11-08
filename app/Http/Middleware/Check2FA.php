<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Check2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Verificar si el usuario está autenticado y si ha validado el código 2FA
         if (Auth::check() && !Auth::user()->codigo_2fa_validado) {
            // Redirigir al usuario a la página de verificación 2FA
            return redirect()->route('2fa.show');
        }

        return $next($request);
    }
}
