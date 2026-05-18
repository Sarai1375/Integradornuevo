<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // ✅ para comprobar contraseñas
use Illuminate\Support\Facades\Mail;


class UsuariosController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $usuario = DB::table('usuarios')->get();
        return view('cpanel.usuarios.indexusuarios', ['data' => $usuario]);
    }

    public function create()
    {
        return view('cpanel.usuarios.createusuarios');
    }

public function store(Request $request)
{
    try {

        $request->validate([
            'Nombre'         => 'required',
            'Ape_pat'        => 'required',
            'Ape_mat'        => 'required',
            'Nom_usuario'    => 'required',
            'Email'          => 'required|email',
            'Telefono'       => 'required',
            'Contrasena'     => 'required|min:8',
            'Fecha_registro' => 'required|date',
            'Calle'          => 'required',
            'Numero'         => 'required',
            'CP'             => 'required',
            'Municipio'      => 'required',
            'Estado'         => 'required',
        ]);

        DB::table('usuarios')->insert([
            'Nombre'        => $request->Nombre,
            'Ape_pat'       => $request->Ape_pat,
            'Ape_mat'       => $request->Ape_mat,
            'Nom_usuario'   => $request->Nom_usuario,
            'Email'         => $request->Email,
            'Telefono'      => $request->Telefono,
            'Contrasena'    => Hash::make($request->Contrasena),
            'Rol_id'        => 2,
            'Fecha_registro'=> $request->Fecha_registro,
            'Calle'         => $request->Calle,
            'Numero'        => $request->Numero,
            'CP'            => $request->CP,
            'Municipio'     => $request->Municipio,
            'Estado'        => $request->Estado,

            // 👇 IMPORTANTÍSIMO: forzar valores obligatorios
            'Frecuente'     => 'No',
            'protegido'     => 0,
            'activo'        => 1,
        ]);

       return redirect()->route('login')
    ->with('success', 'Usuario creado correctamente.');

    } catch (\Exception $e) {

        return back()->with('error', $e->getMessage());
    }
}
// REGISTRO DESDE ADMIN
public function storeAdmin(Request $request)
{
    try {

        $request->validate([
            'Nombre'         => 'required',
            'Ape_pat'        => 'required',
            'Ape_mat'        => 'required',
            'Nom_usuario'    => 'required',
            'Email'          => 'required|email',
            'Telefono'       => 'required',
            'Contrasena'     => 'required|min:8',
            'Fecha_registro' => 'required|date',
            'Calle'          => 'required',
            'Numero'         => 'required',
            'CP'             => 'required',
            'Municipio'      => 'required',
            'Estado'         => 'required',
        ]);

        DB::table('usuarios')->insert([
            'Nombre'         => $request->Nombre,
            'Ape_pat'        => $request->Ape_pat,
            'Ape_mat'        => $request->Ape_mat,
            'Nom_usuario'    => $request->Nom_usuario,
            'Email'          => $request->Email,
            'Telefono'       => $request->Telefono,
            'Contrasena'     => Hash::make($request->Contrasena),
            'Rol_id'         => $request->Rol_id ?? 2,
            'Fecha_registro' => $request->Fecha_registro,
            'Calle'          => $request->Calle,
            'Numero'         => $request->Numero,
            'CP'             => $request->CP,
            'Municipio'      => $request->Municipio,
            'Estado'         => $request->Estado,

            'Frecuente'      => 'No',
            'protegido'      => 0,
            'activo'         => 1,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado con éxito.');

    } catch (\Exception $e) {

        return back()->with('error', $e->getMessage());
    }
}
    // EDITAR USUARIO
    public function edit($id_usuario)
    {
        $fila = DB::table('usuarios')
                ->where('Id_Usuario', $id_usuario)
                ->first();

        return view('cpanel.usuarios.editusuarios', ['fila' => $fila]);
    }

    // ACTUALIZAR USUARIO
    public function update(Request $request, $usuario)
    {
        $request->validate([
            'Nombre'         => 'required',
            'Ape_pat'        => 'required',
            'Ape_mat'        => 'required',
            'Nom_usuario'    => 'required',
            'Email'          => 'required|email',
            'Telefono'       => 'required',
            'Contrasena'     => 'required|min:8',
            'Fecha_registro' => 'required|date',
            'Calle'          => 'required',
            'Numero'         => 'required',
            'CP'             => 'required',
            'Municipio'      => 'required',
            'Estado'         => 'required',
            'Frecuente'      => 'required|in:Si,No',
        ]);

        DB::table('usuarios')->where('Id_Usuario', $usuario)->update([
            'Nombre'         => $request->Nombre,
            'Ape_pat'        => $request->Ape_pat,
            'Ape_mat'        => $request->Ape_mat,
            'Nom_usuario'    => $request->Nom_usuario,
            'Email'          => $request->Email,
            'Telefono'       => $request->Telefono,
            'Contrasena'     => Hash::make($request->Contrasena), // cifra la contraseña
            'Fecha_registro' => $request->Fecha_registro,
            'Calle'          => $request->Calle,
            'Numero'         => $request->Numero,
            'CP'             => $request->CP,
            'Municipio'      => $request->Municipio,
            'Estado'         => $request->Estado,
            'Frecuente'      => $request->Frecuente
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    // ELIMINAR USUARIO
    public function destroy($id_usuario)
    {
        DB::table('usuarios')->where('Id_Usuario', $id_usuario)->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    // LOGIN
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $usuario = DB::table('usuarios')
                    ->where('Email', $email)
                    ->first();

        if ($usuario && Hash::check($password, $usuario->Contrasena)) {
            return redirect()->route('bienvenido')
                ->with('success', 'Bienvenido ' . $usuario->Nombre);
        } else {
            return back()->with('error', 'Correo o contraseña incorrectos');
        }
    }

public function eliminarSeleccion(Request $request)
{
    if($request->has('seleccion')){

        $adminProtegido = false;

        foreach($request->seleccion as $id){

            $usuario = DB::table('usuarios')
                ->where('Id_Usuario', $id)
                ->first();

            // PROTEGER ADMINS
            if($usuario->Rol_id == 1 && $usuario->protegido == 1){

                $adminProtegido = true;

                continue;
            }

            // ELIMINAR USUARIO
            DB::table('usuarios')
                ->where('Id_Usuario', $id)
                ->delete();
        }

        // SI INTENTARON BORRAR ADMIN
        if($adminProtegido){

            return back()->with(
                'error',
                'No puedes eliminar administradores protegidos'
            );
        }

        return back()->with(
            'success',
            'Usuarios eliminados correctamente'
        );
    }

    return back()->with(
        'error',
        'No seleccionaste usuarios'
    );
}

public function eliminar($id)
{
    $usuario = DB::table('usuarios')
        ->where('Id_Usuario', $id)
        ->first();

    // Proteger administradores
    if($usuario->Rol_id == 1 && $usuario->protegido == 1){

        return back()->with(
            'error',
            'Este administrador está protegido'
        );
    }

    // ELIMINAR USUARIO
    DB::table('usuarios')
        ->where('Id_Usuario', $id)
        ->delete();

    return back()->with(
        'success',
        'Usuario eliminado correctamente'
    );
}
    public function graficar()
    {
        $usuarios = \DB::table('usuarios')
            ->select('Municipio', \DB::raw('COUNT(*) as total'))
            ->groupBy('Municipio')
            ->orderBy('Municipio')
            ->get();

        return view('cpanel.usuarios.graficar', compact('usuarios'));
    }

public function resetPassword(Request $request)
{
    $request->validate([
        'Email' => 'required|email'
    ]);

    $usuario = DB::table('usuarios')
        ->where('Email', $request->Email)
        ->first();

    if(!$usuario){
        return back()->with('error', 'Ese correo no existe');
    }

    // generar nueva contraseña
    $nuevaPass = 'Pass'.rand(1000,9999);

    // guardar en BD
    DB::table('usuarios')
        ->where('Email', $request->Email)
        ->update([
            'Contrasena' => Hash::make($nuevaPass)
        ]);

    // enviar correo
Mail::send('emails.reset', [
    'nombre' => $usuario->Nombre,
    'password' => $nuevaPass
], function ($message) use ($usuario) {
    $message->to($usuario->Email)
            ->subject('Recuperación de contraseña');
});
    return back()->with('success', 'Te enviamos una nueva contraseña a tu correo.');
}  
}
?>