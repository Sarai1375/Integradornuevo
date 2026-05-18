<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromocionApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = DB::table('promociones')
            ->leftJoin('productos', 'promociones.Id_Producto', '=', 'productos.Id_Producto')
            ->select('promociones.*', 'productos.Nombre as producto_nombre', 'productos.Precio as producto_precio');

        if ($request->boolean('activas')) {
            $query->where('promociones.estado', 'activa')
                ->whereDate('promociones.fecha_inicio', '<=', now())
                ->whereDate('promociones.fecha_fin', '>=', now());
        }

        $promociones = $query->get();

        return response()->json([
            'data' => $promociones,
            'total' => $promociones->count(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $promocion = DB::table('promociones')->where('Id_promocion', $id)->first();

        if (! $promocion) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }

        return response()->json(['data' => $promocion]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'nullable|string',
            'Id_Producto' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('promociones', 'public');
        }

        $id = DB::table('promociones')->insertGetId([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'descuento' => $data['descuento'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'estado' => $data['estado'] ?? 'activa',
            'imagen' => $imagePath,
            'Id_Producto' => $data['Id_Producto'],
        ]);

        $promocion = DB::table('promociones')->where('Id_promocion', $id)->first();

        return response()->json([
            'message' => 'Promoción creada correctamente',
            'data' => $promocion,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $promocion = DB::table('promociones')->where('Id_promocion', $id)->first();

        if (! $promocion) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }

        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'descuento' => 'sometimes|required|numeric|min:0',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin' => 'sometimes|required|date',
            'estado' => 'sometimes|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($promocion->imagen && Storage::disk('public')->exists($promocion->imagen)) {
                Storage::disk('public')->delete($promocion->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('promociones', 'public');
        } else {
            unset($data['imagen']);
        }

        DB::table('promociones')->where('Id_promocion', $id)->update($data);

        $promocion = DB::table('promociones')->where('Id_promocion', $id)->first();

        return response()->json([
            'message' => 'Promoción actualizada correctamente',
            'data' => $promocion,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $promocion = DB::table('promociones')->where('Id_promocion', $id)->first();

        if (! $promocion) {
            return response()->json(['message' => 'Promoción no encontrada'], 404);
        }

        if ($promocion->imagen && Storage::disk('public')->exists($promocion->imagen)) {
            Storage::disk('public')->delete($promocion->imagen);
        }

        DB::table('promociones')->where('Id_promocion', $id)->delete();

        return response()->json(['message' => 'Promoción eliminada correctamente']);
    }
}
