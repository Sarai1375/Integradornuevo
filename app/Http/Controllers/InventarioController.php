<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        // 🌹 PRODUCTOS + PROMOCIONES
        $productos = DB::table('productos')
            ->leftJoin('producto_promocion', 'productos.Id_producto', '=', 'producto_promocion.Id_Producto')
            ->leftJoin('promociones', 'promociones.Id_promocion', '=', 'producto_promocion.Id_promocion')
            ->select(
                'productos.*',
                'promociones.titulo as promocion_titulo',
                'promociones.descuento as promocion_descuento',
                'promociones.estado as promocion_estado'
            )
            ->get();

        // 📦 MATERIALES + PROVEEDORES
       $materiales = DB::table('material')
    ->select(
        'Id_material',
        'Descripcion',
        'Cantidad',
        'Unid_medida'
    )
    ->get();

        // 🚚 PROVEEDORES
        $proveedores = DB::table('proveedores')->get();

        // 📊 KPIs
        $totalProductos = DB::table('productos')->count();
        $totalMateriales = DB::table('material')->count();
        $totalProveedores = DB::table('proveedores')->count();

        return view('cpanel.inventario', compact(
            'productos',
            'materiales',
            'proveedores',
            'totalProductos',
            'totalMateriales',
            'totalProveedores'
        ));
    }

    public function storeMaterial(Request $request)
    {
        // ✅ VALIDACIONES PARA QUE COINCIDA CON TU BD
        $request->validate([
            'descripcion' => 'nullable|string',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:50'
        ]);

        DB::table('material')->insert([
            'Descripcion' => $request->descripcion,
            'Cantidad' => $request->cantidad,
            'Unid_medida' => $request->unidad
        ]);

        return redirect()->route('inventario.index')
            ->with('success', 'Material agregado correctamente');
    }
    public function updateMaterial(Request $request, $id)
{
    // Validación básica
    $request->validate([
        'descripcion' => 'nullable|string',
        'cantidad' => 'nullable|integer',
        'unidad' => 'nullable|string|max:50'
    ]);

    DB::table('material')
        ->where('Id_material', $id)
        ->update([
            'Descripcion' => $request->descripcion,
            'Cantidad' => $request->cantidad,
            'Unid_medida' => $request->unidad
        ]);

    return redirect()->route('inventario.index')
        ->with('success', 'Material actualizado correctamente');
}
public function destroyMaterial($id)
{
    DB::table('material')
        ->where('Id_material', $id)
        ->delete();

    return redirect()->route('inventario.index')
        ->with('success', 'Material eliminado correctamente');
}
}