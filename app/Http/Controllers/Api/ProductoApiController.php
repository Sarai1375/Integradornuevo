<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoApiController extends Controller
{
    public function index(): JsonResponse
    {
        $productos = DB::table('productos')->get();

        return response()->json([
            'data' => $productos,
            'total' => $productos->count(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $producto = DB::table('productos')
            ->where('Id_Producto', $id)
            ->first();

        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json(['data' => $producto]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string',
            'Precio' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
            'Insumo' => 'nullable|string',
            'Imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('Imagen')) {
            $rutaImagen = $request->file('Imagen')->store('productos', 'public');
        }

        $id = DB::table('productos')->insertGetId([
            'Nombre' => $data['Nombre'],
            'Descripcion' => $data['Descripcion'],
            'Precio' => $data['Precio'],
            'Stock' => $data['Stock'],
            'Insumo' => $data['Insumo'] ?? null,
            'Imagen' => $rutaImagen,
        ]);

        $producto = DB::table('productos')->where('Id_Producto', $id)->first();

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data' => $producto,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $producto = DB::table('productos')->where('Id_Producto', $id)->first();

        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $data = $request->validate([
            'Nombre' => 'sometimes|required|string|max:255',
            'Descripcion' => 'sometimes|required|string',
            'Precio' => 'sometimes|required|numeric|min:0',
            'Stock' => 'sometimes|required|integer|min:0',
            'Insumo' => 'nullable|string',
            'Imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = $producto->Imagen;

        if ($request->hasFile('Imagen')) {
            if ($producto->Imagen && Storage::disk('public')->exists($producto->Imagen)) {
                Storage::disk('public')->delete($producto->Imagen);
            }

            $rutaImagen = $request->file('Imagen')->store('productos', 'public');
        }

        $update = array_filter([
            'Nombre' => $data['Nombre'] ?? null,
            'Descripcion' => $data['Descripcion'] ?? null,
            'Precio' => $data['Precio'] ?? null,
            'Stock' => $data['Stock'] ?? null,
            'Insumo' => $data['Insumo'] ?? null,
            'Imagen' => $rutaImagen,
        ], fn ($v) => $v !== null);

        DB::table('productos')->where('Id_Producto', $id)->update($update);

        $producto = DB::table('productos')->where('Id_Producto', $id)->first();

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'data' => $producto,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $producto = DB::table('productos')->where('Id_Producto', $id)->first();

        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        if ($producto->Imagen && Storage::disk('public')->exists($producto->Imagen)) {
            Storage::disk('public')->delete($producto->Imagen);
        }

        DB::table('productos')->where('Id_Producto', $id)->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
