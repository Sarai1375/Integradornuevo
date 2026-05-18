<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Autenticado
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('usuario_logueado')) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión para acceder a esta página');
        }

        return $next($request);
    }
}
