<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorApiController extends Controller
{
    public function index(): JsonResponse
    {
        $proveedores = DB::table('Proveedores')->get();

        return response()->json([
            'data' => $proveedores,
            'total' => $proveedores->count(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();

        if (! $proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        return response()->json(['data' => $proveedor]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_pat' => 'required|string|max:100',
            'apellido_mat' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'required|string|max:20',
            'RFC' => 'required|string|max:13',
        ]);

        $id = DB::table('Proveedores')->insertGetId($data);
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();

        return response()->json([
            'message' => 'Proveedor creado correctamente',
            'data' => $proveedor,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();

        if (! $proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'apellido_pat' => 'sometimes|required|string|max:100',
            'apellido_mat' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|max:100',
            'telefono' => 'sometimes|required|string|max:20',
            'RFC' => 'sometimes|required|string|max:13',
        ]);

        DB::table('Proveedores')->where('Id_proveedores', $id)->update($data);
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();

        return response()->json([
            'message' => 'Proveedor actualizado correctamente',
            'data' => $proveedor,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $proveedor = DB::table('Proveedores')->where('Id_proveedores', $id)->first();

        if (! $proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        DB::table('Proveedores')->where('Id_proveedores', $id)->delete();

        return response()->json(['message' => 'Proveedor eliminado correctamente']);
    }
}
