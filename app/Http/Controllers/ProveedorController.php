<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    // Mostrar la lista de proveedores
    public function index()
    {
        $proveedores = DB::table('Proveedores')->get();
        return view('cpanel.proveedores.indexproveedores', compact('proveedores'));
    }

    // Mostrar formulario para crear un proveedor
    public function create()
    {
        return view('cpanel.proveedores.createproveedor');
    }

    // Guardar nuevo proveedor en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'apellido_pat' => 'required|max:100',
            'apellido_mat' => 'required|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|max:20',
            'RFC' => 'required|max:13',
        ]);

        DB::table('Proveedores')->insert([
            'nombre' => $request->nombre,
            'apellido_pat' => $request->apellido_pat,
            'apellido_mat' => $request->apellido_mat,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'RFC' => $request->RFC,
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor agregado correctamente.');
    }

    // Mostrar formulario para editar un proveedor
    public function edit($id)
    {
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();
        return view('cpanel.proveedores.editproveedor', compact('proveedor'));
    }

    // Actualizar proveedor en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'apellido_pat' => 'required|max:100',
            'apellido_mat' => 'required|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|max:20',
            'RFC' => 'required|max:13',
        ]);

        DB::table('Proveedores')->where('Id_proveedores', $id)->update([
            'nombre' => $request->nombre,
            'apellido_pat' => $request->apellido_pat,
            'apellido_mat' => $request->apellido_mat,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'RFC' => $request->RFC,
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar proveedor
    public function destroy($id)
    {
        DB::table('Proveedores')->where('Id_proveedores', $id)->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
