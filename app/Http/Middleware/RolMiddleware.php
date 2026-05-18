<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session('usuario_logueado')) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión');
        }

        $rolUsuario = strtolower(trim(session('rol', '')));
        $rolesPermitidos = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($rolUsuario, $rolesPermitidos)) {
            abort(403, 'No tienes permiso para acceder a esta sección');
        }

        return $next($request);
    }
}
