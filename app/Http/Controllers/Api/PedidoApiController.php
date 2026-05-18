<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = DB::table('pedidos');

        if ($request->filled('usuario')) {
            $query->where('Id_Usuario', $request->integer('usuario'));
        }

        if ($request->filled('estado')) {
            $query->where('Estado_pedido', $request->string('estado'));
        }

        $pedidos = $query->orderBy('Id_ped', 'desc')->get();

        return response()->json([
            'data' => $pedidos,
            'total' => $pedidos->count(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $pedido = DB::table('pedidos')->where('Id_ped', $id)->first();

        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $productos = DB::table('incluye as i')
            ->join('productos as p', 'i.Id_Producto', '=', 'p.Id_Producto')
            ->where('i.Id_ped', $id)
            ->select('p.Id_Producto', 'p.Nombre', 'i.Cantidad', 'i.Precio_unitario', 'i.Subtotal')
            ->get();

        return response()->json([
            'data' => $pedido,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Cantidad_paquetes' => 'required|integer|min:1',
            'Fecha_entrega' => 'required|date|after_or_equal:today',
            'Tipo_entrega' => 'required|in:Domicilio,Sucursal',
            'Total_pedido' => 'required|numeric|min:1',
            'Id_Usuario' => 'required|integer',
            'Id_promocion' => 'nullable|integer',
            'Observaciones' => 'nullable|string',
            'Estado_pedido' => 'nullable|string',
            'Estado_Pago' => 'nullable|string',
            'Comprobante' => 'nullable|string',
        ]);

        if ($data['Tipo_entrega'] === 'Domicilio' && $data['Cantidad_paquetes'] < 7) {
            return response()->json([
                'message' => 'Para envío a domicilio el mínimo es de 7 paquetes.',
            ], 422);
        }

        if (! empty($data['Id_promocion'])) {
            $promocion = DB::table('promociones')
                ->where('Id_promocion', $data['Id_promocion'])
                ->where('estado', 'Activa')
                ->whereDate('fecha_inicio', '<=', now())
                ->whereDate('fecha_fin', '>=', now())
                ->first();

            if (! $promocion) {
                return response()->json([
                    'message' => 'La promoción ya expiró o no está disponible.',
                ], 422);
            }
        }

        $id = DB::table('pedidos')->insertGetId([
            'Fecha_entrega' => $data['Fecha_entrega'],
            'Fecha_realizada' => now(),
            'Total_pedido' => $data['Total_pedido'],
            'Id_Usuario' => $data['Id_Usuario'],
            'Cantidad_paquetes' => $data['Cantidad_paquetes'],
            'Estado_pedido' => $data['Estado_pedido'] ?? 'Pendiente',
            'Tipo_entrega' => $data['Tipo_entrega'],
            'Id_promocion' => $data['Id_promocion'] ?? null,
            'Observaciones' => $data['Observaciones'] ?? null,
            'Comprobante' => $data['Comprobante'] ?? null,
            'Estado_Pago' => $data['Estado_Pago'] ?? 'Pendiente',
        ]);

        $pedido = DB::table('pedidos')->where('Id_ped', $id)->first();

        return response()->json([
            'message' => 'Pedido creado correctamente',
            'data' => $pedido,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $pedido = DB::table('pedidos')->where('Id_ped', $id)->first();

        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $data = $request->validate([
            'Estado_pedido' => 'sometimes|string',
            'Estado_Pago' => 'sometimes|string',
            'Tipo_entrega' => 'sometimes|in:Domicilio,Sucursal',
            'Fecha_entrega' => 'sometimes|date',
            'Observaciones' => 'nullable|string',
            'Comprobante' => 'nullable|string',
        ]);

        DB::table('pedidos')->where('Id_ped', $id)->update($data);

        $pedido = DB::table('pedidos')->where('Id_ped', $id)->first();

        return response()->json([
            'message' => 'Pedido actualizado correctamente',
            'data' => $pedido,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $pedido = DB::table('pedidos')->where('Id_ped', $id)->first();

        if (! $pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        DB::table('pedidos')->where('Id_ped', $id)->delete();

        return response()->json(['message' => 'Pedido eliminado correctamente']);
    }
}
