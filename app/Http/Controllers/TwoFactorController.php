<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    // Mostrar formulario para ingresar código
    public function index()
    {
        // Si no hay sesión activa de 2FA, regresar a login
        if (!session('2fa_email')) {
            return redirect()->route('login');
        }

        return view('cpanel.usuarios.twofactor');
    }

    // Verificar código
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $email = session('2fa_email');

        // Buscar código en BD
        $registro = DB::table('two_factor_codes')
            ->where('email', $email)
            ->where('code', $request->code)
            ->first();

        // ❌ Código incorrecto
        if (!$registro) {
            return back()->withErrors(['code' => 'Código incorrecto']);
        }

        // ⏳ Verificar expiración (5 minutos)
        $tiempo = now()->diffInMinutes($registro->created_at);

        if ($tiempo > 15) {
            return back()->withErrors(['code' => 'Código expirado']);
        }

        // ✅ Código válido → eliminarlo
        DB::table('two_factor_codes')
            ->where('email', $email)
            ->delete();

        // 🔐 Activar sesión completa
        session([
            'usuario_logueado' => true
        ]);

        // limpiar datos temporales
        session()->forget(['2fa_email']);

        return redirect()->route('bienvenido')
            ->with('success', 'Inicio de sesión exitoso');
    }
    public function sendCode()
{
    if (!session('2fa_email')) {
        return redirect()->route('login');
    }

    $email = session('2fa_email');

    $code = rand(100000, 999999);

    DB::table('two_factor_codes')
        ->where('email', $email)
        ->delete();

    DB::table('two_factor_codes')->insert([
        'email' => $email,
        'code' => $code,
        'created_at' => now()
    ]);

  Mail::send('emails.2fa', ['codigo' => $code], function ($message) use ($email) {
    $message->to($email)
            ->subject('Código de verificación');
});

    return back()->with('success', 'Código reenviado correctamente');
}
    
}