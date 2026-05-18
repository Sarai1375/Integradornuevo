<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{


  public function detalle($id)
{
    $pedido = DB::table('pedidos')
        ->where('Id_ped', $id)
        ->first();

    if (!$pedido) {
        return back()->with('error', 'Pedido no encontrado');
    }

    $productos = DB::table('incluye as i')
        ->join('productos as p', 'i.Id_Producto', '=', 'p.Id_Producto')
        ->where('i.Id_ped', $id)
        ->select(
            'p.Nombre',
            'i.Cantidad',
            'i.Precio_unitario',
            'i.Subtotal'
        )
        ->get();

    return view('cliente.pedido_detalle', compact('pedido', 'productos'));
}
    public function guardar(Request $request)
{
    // VALIDACIONES
    $request->validate([

        'Cantidad_paquetes' => 'required|integer|min:1',

        'Fecha_entrega' => [
            'required',
            'date',
            'after_or_equal:today',
            'before_or_equal:' . now()->addDays(7)->format('Y-m-d')
        ],

        'Tipo_entrega' => 'required|in:Domicilio,Sucursal',

        'Total_pedido' => 'required|numeric|min:1'

    ]);

    // =========================================
    // GUARDAR COMPROBANTE
    // =========================================

    $ruta = null;

    if($request->hasFile('Comprobante_pago')){

        $imagen = $request->file('Comprobante_pago');

        $nombre = time().'_'.$imagen->getClientOriginalName();

        $imagen->move(public_path('comprobantes'), $nombre);

        $ruta = 'comprobantes/'.$nombre;
    }

    // VALIDAR MÍNIMO PARA DOMICILIO
    if (
        $request->Tipo_entrega == 'Domicilio' &&
        $request->Cantidad_paquetes < 7
    ) {

        return back()->with(
            'error',
            'Para envío a domicilio el mínimo es de 7 paquetes.'
        );
    }

    // VALIDAR PROMOCIÓN
    if ($request->Id_promocion) {

        $promocion = DB::table('promociones')
            ->where('Id_promocion', $request->Id_promocion)
            ->where('estado', 'Activa')
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->first();

        if (!$promocion) {

            return back()->with(
                'error',
                'La promoción ya expiró o no está disponible.'
            );
        }
    }

    // GUARDAR PEDIDO
    DB::table('pedidos')->insert([

        'Fecha_entrega' => $request->Fecha_entrega,

        'Fecha_realizada' => now(),

        'Total_pedido' => $request->Total_pedido,

        'Id_Usuario' => session('id_usuario'),

        'Cantidad_paquetes' => $request->Cantidad_paquetes,

        'Estado_pedido' => 'Pendiente',

        'Tipo_entrega' => $request->Tipo_entrega,

        'Id_promocion' => $request->Id_promocion,

        'Observaciones' => $request->Observaciones,

        'Comprobante' => $ruta,

        'Estado_Pago' => 'Pendiente'
    ]);

    return back()->with(
        'success',
        'Pedido realizado correctamente.'
    );
}
   
  
}