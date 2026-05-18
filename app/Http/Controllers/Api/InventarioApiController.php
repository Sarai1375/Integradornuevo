<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioApiController extends Controller
{
    public function resumen(): JsonResponse
    {
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

        $materiales = DB::table('material')->get();
        $proveedores = DB::table('Proveedores')->get();

        return response()->json([
            'productos' => $productos,
            'materiales' => $materiales,
            'proveedores' => $proveedores,
            'kpis' => [
                'total_productos' => DB::table('productos')->count(),
                'total_materiales' => DB::table('material')->count(),
                'total_proveedores' => DB::table('Proveedores')->count(),
            ],
        ]);
    }

    public function indexMateriales(): JsonResponse
    {
        $materiales = DB::table('material')->get();

        return response()->json([
            'data' => $materiales,
            'total' => $materiales->count(),
        ]);
    }

    public function showMaterial(int $id): JsonResponse
    {
        $material = DB::table('material')->where('Id_material', $id)->first();

        if (! $material) {
            return response()->json(['message' => 'Material no encontrado'], 404);
        }

        return response()->json(['data' => $material]);
    }

    public function storeMaterial(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Descripcion' => 'required|string',
            'Cantidad' => 'required|integer|min:0',
            'Unid_medida' => 'required|string|max:50',
        ]);

        $id = DB::table('material')->insertGetId($data);
        $material = DB::table('material')->where('Id_material', $id)->first();

        return response()->json([
            'message' => 'Material creado correctamente',
            'data' => $material,
        ], 201);
    }

    public function updateMaterial(Request $request, int $id): JsonResponse
    {
        $material = DB::table('material')->where('Id_material', $id)->first();

        if (! $material) {
            return response()->json(['message' => 'Material no encontrado'], 404);
        }

        $data = $request->validate([
            'Descripcion' => 'sometimes|required|string',
            'Cantidad' => 'sometimes|required|integer|min:0',
            'Unid_medida' => 'sometimes|required|string|max:50',
        ]);

        DB::table('material')->where('Id_material', $id)->update($data);
        $material = DB::table('material')->where('Id_material', $id)->first();

        return response()->json([
            'message' => 'Material actualizado correctamente',
            'data' => $material,
        ]);
    }

    public function destroyMaterial(int $id): JsonResponse
    {
        $material = DB::table('material')->where('Id_material', $id)->first();

        if (! $material) {
            return response()->json(['message' => 'Material no encontrado'], 404);
        }

        DB::table('material')->where('Id_material', $id)->delete();

        return response()->json(['message' => 'Material eliminado correctamente']);
    }
}
