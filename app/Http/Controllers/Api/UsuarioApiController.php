<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioApiController extends Controller
{
    private const HIDDEN = ['Contrasena'];

    public function index(Request $request): JsonResponse
    {
        $query = DB::table('usuarios');

        if ($request->filled('rol')) {
            $query->where('Rol_id', $request->integer('rol'));
        }

        if ($request->filled('municipio')) {
            $query->where('Municipio', $request->string('municipio'));
        }

        $usuarios = $query->get()->map(fn ($u) => $this->scrub($u));

        return response()->json([
            'data' => $usuarios,
            'total' => $usuarios->count(),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = DB::table('usuarios')->where('Id_Usuario', $id)->first();

        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['data' => $this->scrub($usuario)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'Nombre' => 'required|string|max:100',
            'Ape_pat' => 'required|string|max:100',
            'Ape_mat' => 'required|string|max:100',
            'Nom_usuario' => 'required|string|max:100',
            'Email' => 'required|email|max:150|unique:usuarios,Email',
            'Telefono' => 'required|string|max:20',
            'Contrasena' => 'required|string|min:8',
            'Rol_id' => 'nullable|integer',
            'Calle' => 'required|string',
            'Numero' => 'required|string',
            'CP' => 'required|string|max:10',
            'Municipio' => 'required|string',
            'Estado' => 'required|string',
        ]);

        $id = DB::table('usuarios')->insertGetId([
            'Nombre' => $data['Nombre'],
            'Ape_pat' => $data['Ape_pat'],
            'Ape_mat' => $data['Ape_mat'],
            'Nom_usuario' => $data['Nom_usuario'],
            'Email' => $data['Email'],
            'Telefono' => $data['Telefono'],
            'Contrasena' => Hash::make($data['Contrasena']),
            'Rol_id' => $data['Rol_id'] ?? 2,
            'Fecha_registro' => now()->toDateString(),
            'Calle' => $data['Calle'],
            'Numero' => $data['Numero'],
            'CP' => $data['CP'],
            'Municipio' => $data['Municipio'],
            'Estado' => $data['Estado'],
            'Frecuente' => 'No',
            'protegido' => 0,
            'activo' => 1,
        ]);

        $usuario = DB::table('usuarios')->where('Id_Usuario', $id)->first();

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data' => $this->scrub($usuario),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $usuario = DB::table('usuarios')->where('Id_Usuario', $id)->first();

        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $data = $request->validate([
            'Nombre' => 'sometimes|required|string|max:100',
            'Ape_pat' => 'sometimes|required|string|max:100',
            'Ape_mat' => 'sometimes|required|string|max:100',
            'Nom_usuario' => 'sometimes|required|string|max:100',
            'Email' => 'sometimes|required|email|max:150',
            'Telefono' => 'sometimes|required|string|max:20',
            'Contrasena' => 'sometimes|nullable|string|min:8',
            'Rol_id' => 'sometimes|integer',
            'Calle' => 'sometimes|required|string',
            'Numero' => 'sometimes|required|string',
            'CP' => 'sometimes|required|string|max:10',
            'Municipio' => 'sometimes|required|string',
            'Estado' => 'sometimes|required|string',
            'Frecuente' => 'sometimes|in:Si,No',
            'activo' => 'sometimes|boolean',
        ]);

        if (! empty($data['Contrasena'])) {
            $data['Contrasena'] = Hash::make($data['Contrasena']);
        } else {
            unset($data['Contrasena']);
        }

        DB::table('usuarios')->where('Id_Usuario', $id)->update($data);

        $usuario = DB::table('usuarios')->where('Id_Usuario', $id)->first();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data' => $this->scrub($usuario),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $usuario = DB::table('usuarios')->where('Id_Usuario', $id)->first();

        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        if ($usuario->Rol_id == 1 && $usuario->protegido == 1) {
            return response()->json([
                'message' => 'Este administrador está protegido',
            ], 403);
        }

        DB::table('usuarios')->where('Id_Usuario', $id)->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function clientes(): JsonResponse
    {
        $clientes = DB::table('usuarios')
            ->where('Rol_id', 2)
            ->get()
            ->map(fn ($u) => $this->scrub($u));

        return response()->json([
            'data' => $clientes,
            'total' => $clientes->count(),
        ]);
    }

    private function scrub(object $usuario): object
    {
        foreach (self::HIDDEN as $field) {
            unset($usuario->{$field});
        }

        return $usuario;
    }
}
