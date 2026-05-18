<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    // LISTAR PRODUCTOS
    public function index()
    {

        $productos = DB::table('productos')->get();

        return view('cpanel.productos.index', compact('productos'));

    }

    // MOSTRAR FORMULARIO CREAR
    public function create()
    {

        return view('cpanel.productos.create');

    }

    // GUARDAR PRODUCTO
    public function store(Request $request)
{

    $request->validate([

        'Nombre' => 'required',
        'Descripcion' => 'required',
        'Precio' => 'required|numeric',
        'Stock' => 'required|integer',
        'Imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

    ]);

    // 🔥 GUARDAR IMAGEN

    $rutaImagen = null;

    if ($request->hasFile('Imagen')) {

        $rutaImagen = $request->file('Imagen')
                              ->store('productos', 'public');

    }

    DB::table('productos')->insert([

        'Nombre' => $request->Nombre,
        'Descripcion' => $request->Descripcion,
        'Precio' => $request->Precio,
        'Stock' => $request->Stock,
        'Insumo' => $request->Insumo,
        'Imagen' => $rutaImagen

    ]);

    return redirect()
        ->route('productos.index')
        ->with('success', 'Producto agregado correctamente');
}

    // EDITAR
    public function edit($id)
    {

        $producto = DB::table('productos')
            ->where('Id_Producto', $id)
            ->first();

        return view('cpanel.productos.edit', compact('producto'));

    }

    // ACTUALIZAR
    public function update(Request $request, $id)
{
    $request->validate([
        'Nombre' => 'required',
        'Precio' => 'required|numeric',
        'Stock' => 'required|integer',
        'Descripcion' => 'required',
        'Insumo' => 'required',
        'Imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $producto = DB::table('productos')
        ->where('Id_Producto', $id)
        ->first();

    // Nombre de imagen actual
    $rutaImagen = $producto->Imagen;

    // Si subieron nueva imagen
    if($request->hasFile('Imagen'))
    {
        // Eliminar imagen anterior
        if($producto->Imagen && Storage::disk('public')->exists($producto->Imagen))
        {
            Storage::disk('public')->delete($producto->Imagen);
        }

        // Guardar nueva imagen
        $rutaImagen = $request->file('Imagen')
            ->store('productos', 'public');
    }

    // Actualizar producto
    DB::table('productos')
        ->where('Id_Producto', $id)
        ->update([

            'Nombre' => $request->Nombre,
            'Precio' => $request->Precio,
            'Stock' => $request->Stock,
            'Descripcion' => $request->Descripcion,
            'Insumo' => $request->Insumo,
            'Imagen' => $rutaImagen

        ]);

    return redirect()
        ->route('productos.index')
        ->with('success', 'Producto actualizado correctamente');
}
    // ELIMINAR
    public function destroy($id)
    {

        DB::table('productos')
            ->where('Id_Producto', $id)
            ->delete();

        return redirect()
            ->route('productos.index')
            ->with('success','Producto eliminado');

    }

}