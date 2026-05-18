<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodigoPostalController extends Controller
{
    // IMPORTAR CSV
    public function importar()
    {
        $archivo = storage_path('app/cp.csv');

        // leer archivo
        $csv = array_map('str_getcsv', file($archivo));

        // quitar encabezados
        array_shift($csv);

        foreach ($csv as $fila) {

            DB::table('codigos_postales')->insert([
                'cp' => $fila[0],
                'colonia' => $fila[1],
                'municipio' => $fila[2],
                'estado' => $fila[3],
            ]);
        }

        return "CP importados correctamente";
    }

    // BUSCAR CP
    public function buscar($cp)
    {
        $codigo = DB::table('codigos_postales')
            ->where('cp', $cp)
            ->first();

        return response()->json($codigo);
    }
}