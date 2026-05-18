<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromocionesController extends Controller
{
    // =========================
    // 🔵 ADMIN - LISTADO
    // =========================
  public function adminIndex()
{
    $promociones = DB::table('promociones')->get();

    return view('cpanel.promociones.index', compact('promociones'));
}

    // =========================
    // 🟢 CLIENTE - SOLO ACTIVAS
    // =========================
public function clientePromociones()
{
    $promociones = DB::table('promociones')
        ->join('productos', 'promociones.Id_Producto', '=', 'productos.Id_Producto')
        ->select(
            'promociones.*',
            'productos.Nombre',
            'productos.Precio as precio_original'
        )
        ->where('estado', 'activa')
        ->whereDate('fecha_inicio', '<=', now())
        ->whereDate('fecha_fin', '>=', now())
        ->get();

    return view('cliente.promociones', compact('promociones'));
}
public function create()
{
    $productos = DB::table('productos')->get();

    return view('cpanel.promociones.create', compact('productos'));
}
    // =========================
    // 🔵 STORE
    // =========================
  public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required',
        'descuento' => 'required',
        'Id_Producto' => 'required'
    ]);
if ($request->hasFile('imagen')) {
    $imagePath = $request->file('imagen')->store('promociones', 'public');
} else {
    $imagePath = null;
}
    DB::table('promociones')->insert([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'descuento' => $request->descuento,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'estado' => $request->estado,
        'imagen' => $imagePath, // si luego quieres subir archivos lo mejoramos
        'Id_Producto' => $request->Id_Producto
    ]);

    return redirect()->route('admin.promociones')
        ->with('success', 'Promoción creada correctamente');
}

    // =========================
    // 🔵 EDIT
    // =========================
    public function edit($id)
    {
        $promocion = DB::table('promociones')
            ->where('Id_promocion', $id)
            ->first();

        return view('cpanel.promociones.edit', compact('promocion'));
    }

    // =========================
    // 🔵 UPDATE
    // =========================
public function update(Request $request, $id)
{
    $datos = [
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'descuento' => $request->descuento,
    ];

    // SI SUBE NUEVA IMAGEN
    if($request->hasFile('imagen'))
    {
        $ruta = $request->file('imagen')
                         ->store('promociones', 'public');

        $datos['imagen'] = $ruta;
    }

    DB::table('promociones')
        ->where('Id_promocion', $id)
        ->update($datos);

    return redirect()
            ->route('admin.promociones')
            ->with('success', 'Promoción actualizada');
}

    // =========================
    // 🔵 DELETE
    // =========================
    public function destroy($id)
    {
        DB::table('promociones')
            ->where('Id_promocion', $id)
            ->delete();

        return back()->with('success', 'Promoción eliminada');
    }
}