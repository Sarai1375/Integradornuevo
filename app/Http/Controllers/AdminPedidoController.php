<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoEstadoMail;

class AdminPedidoController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR PEDIDOS
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $pedidos = DB::table('pedidos as p')

            ->join(
                'usuarios as u',
                'p.Id_Usuario',
                '=',
                'u.Id_Usuario'
            )

            ->leftJoin(
                'pago as pa',
                'p.Id_ped',
                '=',
                'pa.Id_ped'
            )

            ->select(

                'p.*',

                'u.Nombre',
                'u.Ape_pat',

                'pa.metodo_pago',
                'pa.Estado',
                'pa.comprobante'

            )

            ->orderBy('p.Id_ped', 'desc')

            ->get();

        return view(
            'admin.pedidos',
            compact('pedidos')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APROBAR PAGO
    |--------------------------------------------------------------------------
    */

 public function aprobar($id)
{

    $pago = DB::table('pago')
        ->where('Id_ped', $id)
        ->first();

    if(!$pago){

        return back()->with(
            'error',
            'Pago no encontrado.'
        );
    }

    if($pago->Estado != 'Pendiente'){

        return back()->with(
            'error',
            'Este pago ya fue procesado.'
        );
    }

    DB::table('pago')
        ->where('Id_ped', $id)
        ->update([

            'Estado' => 'Aprobado'

        ]);

    DB::table('pedidos')
        ->where('Id_ped', $id)
        ->update([

            'Estado_pedido' => 'Confirmado'

        ]);

    return back()->with(
        'success',
        'Pago aprobado correctamente.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | RECHAZAR PAGO
    |--------------------------------------------------------------------------
    */

public function rechazar($id)
{

    $pago = DB::table('pago')
        ->where('Id_ped', $id)
        ->first();

    if(!$pago){

        return back()->with(
            'error',
            'Pago no encontrado.'
        );
    }

    if($pago->Estado != 'Pendiente'){

        return back()->with(
            'error',
            'Este pago ya fue procesado.'
        );
    }

    DB::table('pago')
        ->where('Id_ped', $id)
        ->update([

            'Estado' => 'Rechazado'

        ]);

    DB::table('pedidos')
        ->where('Id_ped', $id)
        ->update([

            'Estado_pedido' => 'Cancelado'

        ]);

    return back()->with(
        'success',
        'Pago rechazado.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | MARCAR ENVIADO
    |--------------------------------------------------------------------------
    */

public function cambiarEstado(Request $request, $id)
{
    $request->validate([
        'Estado_pedido' => 'required|in:Pendiente,Confirmado,Enviado,Entregado,Cancelado'
    ]);

    $pedido = DB::table('pedidos')
        ->where('Id_ped', $id)
        ->first();

    if (!$pedido) {
        return back()->with('error', 'Pedido no encontrado');
    }

    DB::table('pedidos')
        ->where('Id_ped', $id)
        ->update([
            'Estado_pedido' => $request->Estado_pedido
        ]);

    $usuario = DB::table('usuarios')
        ->where('Id_Usuario', $pedido->Id_Usuario)
        ->first();

    Mail::to($usuario->Email)->send(
        new PedidoEstadoMail($pedido, $request->Estado_pedido)
    );

    return back()->with('success', 'Estado actualizado y correo enviado 📩');
}
  public function enviado($id)
{

    $pedido = DB::table('pedidos')
        ->where('Id_ped', $id)
        ->first();

    if($pedido->Estado_pedido != 'Confirmado'){

        return back()->with(
            'error',
            'El pedido aún no está confirmado.'
        );
    }

    DB::table('pedidos')
        ->where('Id_ped', $id)
        ->update([

            'Estado_pedido' => 'Enviado'

        ]);

    return back()->with(
        'success',
        'Pedido marcado como enviado.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | MARCAR ENTREGADO
    |--------------------------------------------------------------------------
    */

public function entregado($id)
{

    $pedido = DB::table('pedidos')
        ->where('Id_ped', $id)
        ->first();

    if($pedido->Estado_pedido != 'Enviado'){

        return back()->with(
            'error',
            'El pedido aún no ha sido enviado.'
        );
    }

    DB::table('pedidos')
        ->where('Id_ped', $id)
        ->update([

            'Estado_pedido' => 'Entregado'

        ]);

    DB::table('pago')
        ->where('Id_ped', $id)
        ->update([

            'Estado' => 'Pagado'

        ]);

    return back()->with(
        'success',
        'Pedido entregado correctamente.'
    );
}


}
