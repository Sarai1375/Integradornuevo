<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica sesión + rol
        if (!session('usuario_logueado') || session('rol') !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
