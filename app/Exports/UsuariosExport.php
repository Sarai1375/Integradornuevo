<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UsuariosExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithCustomStartCell
{

    // INICIAR HEADERS EN FILA 3
    public function startCell(): string
    {
        return 'A3';
    }

    // DATOS
    public function collection()
    {
        return DB::table('usuarios')
            ->select(
                'Id_Usuario',
                'Nombre',
                'Ape_pat',
                'Ape_mat',
                'Nom_usuario',
                'Email',
                'Telefono',
                'Contrasena',
                'Rol_id',
                'Fecha_registro',
                'Calle',
                'Numero',
                'CP',
                'Municipio',
                'Estado',
                'Frecuente',
                'protegido',
                'activo'
            )
            ->get();
    }

    // NOMBRES DE COLUMNAS
    public function headings(): array
    {
        return [

            'ID',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Usuario',
            'Correo',
            'Teléfono',
            'Contraseña',
            'Rol',
            'Fecha Registro',
            'Calle',
            'Número',
            'CP',
            'Municipio',
            'Estado',
            'Frecuente',
            'Protegido',
            'Activo'

        ];
    }

    // ESTILOS
    public function styles(Worksheet $sheet)
    {

        // TÍTULO
        $sheet->mergeCells('A1:S1');

        $sheet->setCellValue('A1', 'REPORTE GENERAL DE USUARIOS');

        $sheet->getStyle('A1')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['rgb' => 'FFFFFF'],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '7A0019'
                ]
            ],

        ]);

        // ALTURA TÍTULO
        $sheet->getRowDimension(1)->setRowHeight(35);

        // ENCABEZADOS
        $sheet->getStyle('A3:R3')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'B22222'
                ]
            ],

        ]);

        // BORDES
        $ultimaFila = $sheet->getHighestRow();

        $sheet->getStyle("A3:R{$ultimaFila}")
            ->applyFromArray([

                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D3D3D3'],
                    ],
                ],

            ]);

        // CENTRAR CONTENIDO
        $sheet->getStyle("A3:R{$ultimaFila}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}