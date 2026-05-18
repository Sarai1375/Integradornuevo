<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class Reportescontroller extends Controller
{
    public function GenerarPDF()
    {
        // Obtener todos los usuarios
        $usuarios = DB::table('usuarios')->get();

        // Generar PDF
        $pdf = Pdf::loadView('cpanel.reportes.pdf', ['data' => $usuarios]);

        // Descargar PDF
        return $pdf->download('reportes.pdf');
    }

    //EXPORTAR EXCEL
    public function ExportarExcel()
    {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    }
}
