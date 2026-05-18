<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EncuestaApiController extends Controller
{
    public function index(): JsonResponse
    {
        if (! Schema::hasTable('encuestas')) {
            return response()->json([
                'data' => [],
                'total' => 0,
                'note' => 'Tabla encuestas no existe todavía.',
            ]);
        }

        $encuestas = DB::table('encuestas')->orderByDesc('id')->get();

        return response()->json([
            'data' => $encuestas,
            'total' => $encuestas->count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Id_Usuario' => 'nullable|integer',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        if (! Schema::hasTable('encuestas')) {
            return response()->json([
                'message' => 'Tabla encuestas no existe; crea una migración antes de usar este endpoint.',
            ], 501);
        }

        $id = DB::table('encuestas')->insertGetId([
            'Id_Usuario' => $data['Id_Usuario'] ?? null,
            'calificacion' => $data['calificacion'],
            'comentario' => $data['comentario'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Encuesta registrada correctamente',
            'data' => DB::table('encuestas')->where('id', $id)->first(),
        ], 201);
    }
}
