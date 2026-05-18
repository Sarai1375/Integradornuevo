<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM LOGIN
    |--------------------------------------------------------------------------
    */
    public function login()
    {
        return view('cpanel.usuarios.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN + GENERAR 2FA
    |--------------------------------------------------------------------------
    */
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario + rol
        $user = DB::table('usuarios as u')
            ->join('roles as r', 'u.Rol_id', '=', 'r.id')
            ->where('u.Email', $request->email)
            ->select('u.*', 'r.nombre as Rol')
            ->first();

        // Verificar usuario
        if (!$user) {
            return back()->withErrors([
                'login' => 'Usuario no encontrado'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PASSWORD
        |--------------------------------------------------------------------------
        | Si usas Hash:
        | Hash::check($request->password, $user->Contrasena)
        |
        | Si NO usas Hash:
        | $request->password != $user->Contrasena
        |--------------------------------------------------------------------------
        */

       if (!Hash::check($request->password, $user->Contrasena)) {

    return back()->withErrors([
        'login' => 'Contraseña incorrecta'
    ]);
}

        /*
        |--------------------------------------------------------------------------
        | GENERAR CÓDIGO 2FA
        |--------------------------------------------------------------------------
        */

        $code = rand(100000, 999999);

        // Eliminar códigos anteriores
        DB::table('two_factor_codes')
            ->where('email', $user->Email)
            ->delete();

        // Guardar nuevo código
        DB::table('two_factor_codes')->insert([
            'email' => $user->Email,
            'code' => $code,
            'created_at' => now()
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUARDAR SESIÓN TEMPORAL
        |--------------------------------------------------------------------------
        */

        session([
            '2fa_email' => $user->Email,
            'usuario_logueado' => false,

            // DATOS USUARIO
            'id_usuario' => $user->Id_Usuario,
            'nombre' => $user->Nombre,
            'ape_pat' => $user->Ape_pat,
            'ape_mat' => $user->Ape_mat,
            'telefono' => $user->Telefono,
            'email' => $user->Email,
            'municipio' => $user->Municipio,
            'estado' => $user->Estado,
            'frecuente' => $user->Frecuente,
            'fecha_registro' => $user->Fecha_registro,

            // ROL
            'rol' => trim(strtolower($user->Rol))
        ]);

        /*
        |--------------------------------------------------------------------------
        | ENVIAR CORREO
        |--------------------------------------------------------------------------
        */

        Mail::raw("Tu código de verificación es: $code", function ($message) use ($user) {

            $message->to($user->Email)
                    ->subject('Código de verificación 2FA');

        });

        return redirect()->route('twofactor.index')
            ->with('success', 'Código enviado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | BIENVENIDA SEGÚN ROL
    |--------------------------------------------------------------------------
    */
public function bienvenido()
{
    // Verificar sesión
    if (session('usuario_logueado') !== true) {
        return redirect()->route('login');
    }

    // Obtener rol
    $rol = strtolower(trim(session('rol')));

    // ADMIN O EMPLEADO
    if ($rol == 'admin' || $rol == 'empleado') {

        return view('cpanel.bienvenido');

    }

    // CLIENTE
    if ($rol == 'cliente') {

        $productos = DB::table('productos')->get();

        return view('cliente.inicio', compact('productos'));

    }

    // Error
    return redirect()->route('login')
        ->with('error', 'Rol no válido');
}
    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        session()->flush();

        return redirect()->route('login');
    }
}