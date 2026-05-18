<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate(['usuario' => 'required|integer']);

        $items = DB::table('carrito as c')
            ->join('productos as p', 'c.Id_Producto', '=', 'p.Id_Producto')
            ->where('c.Id_Usuario', $request->integer('usuario'))
            ->select('c.id', 'c.Id_Usuario', 'c.Id_Producto', 'c.Cantidad', 'c.Subtotal', 'p.Nombre', 'p.Precio', 'p.Imagen')
            ->get();

        return response()->json([
            'data' => $items,
            'total' => $items->sum('Subtotal'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Id_Usuario' => 'required|integer',
            'Id_Producto' => 'required|integer',
            'Cantidad' => 'required|integer|min:1',
        ]);

        $producto = DB::table('productos')->where('Id_Producto', $data['Id_Producto'])->first();
        if (! $producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $subtotal = $producto->Precio * $data['Cantidad'];

        $existente = DB::table('carrito')
            ->where('Id_Usuario', $data['Id_Usuario'])
            ->where('Id_Producto', $data['Id_Producto'])
            ->first();

        if ($existente) {
            $cantidad = $existente->Cantidad + $data['Cantidad'];
            DB::table('carrito')->where('id', $existente->id)->update([
                'Cantidad' => $cantidad,
                'Subtotal' => $producto->Precio * $cantidad,
                'updated_at' => now(),
            ]);
            $id = $existente->id;
        } else {
            $id = DB::table('carrito')->insertGetId([
                'Id_Usuario' => $data['Id_Usuario'],
                'Id_Producto' => $data['Id_Producto'],
                'Cantidad' => $data['Cantidad'],
                'Subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Producto agregado al carrito',
            'data' => DB::table('carrito')->where('id', $id)->first(),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $item = DB::table('carrito')->where('id', $id)->first();
        if (! $item) {
            return response()->json(['message' => 'Item no encontrado'], 404);
        }

        $data = $request->validate([
            'Cantidad' => 'required|integer|min:1',
        ]);

        $producto = DB::table('productos')->where('Id_Producto', $item->Id_Producto)->first();

        DB::table('carrito')->where('id', $id)->update([
            'Cantidad' => $data['Cantidad'],
            'Subtotal' => ($producto?->Precio ?? 0) * $data['Cantidad'],
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Carrito actualizado',
            'data' => DB::table('carrito')->where('id', $id)->first(),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $item = DB::table('carrito')->where('id', $id)->first();
        if (! $item) {
            return response()->json(['message' => 'Item no encontrado'], 404);
        }

        DB::table('carrito')->where('id', $id)->delete();

        return response()->json(['message' => 'Item eliminado del carrito']);
    }
}
