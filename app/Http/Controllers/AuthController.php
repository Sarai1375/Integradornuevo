<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registro(Request $request)
    {
        $usuario = Usuario::create([
            'Nombre' => $request->Nombre,
            'Email' => $request->Email,
            'Contrasena' => Hash::make($request->Contrasena),
            'Rol_id' => 2
        ]);

        return response()->json($usuario);
    }

    public function login(Request $request)
    {
        $usuario = Usuario::where('Email', $request->Email)->first();

        if (!$usuario || !Hash::check($request->Contrasena, $usuario->Contrasena)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return response()->json($usuario);
    }
}