<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        // Verificar si hay sesión activa
        if (!session()->has('usuario')) {
            return redirect()->route('login');
        }

        // Verificar rol
        if (session('usuario')->Rol !== $rol) {
            abort(403, 'No tienes permiso para acceder a esta sección');
        }

        return $next($request);
    }
}
