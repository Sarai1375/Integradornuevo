<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{

//Obtener los productos de la base de datos 
    public function index()
    {
        $productos = DB::table('productos')->get();

        return view('cliente.inicio', compact('productos'));

    }

    public function catalogo()
    {
        $productos = DB::table('productos')->get();

        return view('cliente.catalogo', compact('productos'));

    }


    public function detalleProducto($id)
    {
        $producto = DB::table('productos')
            ->where('Id_Producto', $id)
            ->first();

        if (!$producto) {

            return redirect()->back()
                ->with('error', 'Producto no encontrado');

        }

        return view('cliente.detalle', compact('producto'));

    }

    public function promociones()
    {


        $promociones = DB::table('promociones')->get();

        return view('cliente.promociones', compact('promociones'));

    }

    public function contacto()
    {

        return view('cliente.contacto');

    }


    public function nosotros()
    {

        return view('cliente.nosotros');

    }

public function pedidos()
{
    $pedidos = DB::table('pedidos')
        ->where('Id_Usuario', session('id_usuario'))
        ->orderBy('Id_ped', 'desc')
        ->get();

    return view('cliente.pedidos', compact('pedidos'));
}

public function perfil()
{
    $usuario = DB::table('usuarios')
        ->where('Id_Usuario', session('id_usuario'))
        ->first();

    return view('cliente.perfil', compact('usuario'));
}
public function actualizarPerfil(Request $request)
{
    $request->validate([

        'telefono' => [
            'required',
            'digits:10'
        ],

        'calle' => [
            'required',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'
        ],

        'numero' => [
            'required',
            'numeric'
        ],

        'cp' => [
            'required'
        ],

        'password' => [
            'nullable',
            'min:8',
            'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._-]).+$/'
        ]

    ], [

        'telefono.required' =>
            'El teléfono es obligatorio.',

        'telefono.digits' =>
            'El teléfono debe tener 10 números.',

        'calle.required' =>
            'La calle es obligatoria.',

        'calle.regex' =>
            'La calle solo puede contener letras.',

        'numero.required' =>
            'El número es obligatorio.',

        'numero.numeric' =>
            'El número solo puede contener números.',

        'password.min' =>
            'La contraseña debe tener mínimo 8 caracteres.',

        'password.regex' =>
            'La contraseña debe contener letras, números y caracteres especiales.'

    ]);

    $datos = [

        'Telefono' => $request->telefono,
        'Calle' => $request->calle,
        'Numero' => $request->numero,
        'CP' => $request->cp,
        'Estado' => $request->estado,
        'Municipio' => $request->municipio

    ];

    session([

        'estado' => $request->estado,
        'municipio' => $request->municipio

    ]);

    // SI ESCRIBIÓ NUEVA CONTRASEÑA
    if(
        $request->password != null &&
        $request->password != '********'
    ){

        $datos['Contrasena'] =
            Hash::make($request->password);

    }

    DB::table('usuarios')
        ->where('Id_Usuario', session('id_usuario'))
        ->update($datos);

    // ACTUALIZAR SESSION
    session([
        'telefono' => $request->telefono
    ]);

    return back()->with(
        'success',
        'Perfil actualizado correctamente'
    );
}
}