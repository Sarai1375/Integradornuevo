<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{

public function index()
{
    if (!session('id_usuario')) {
        return redirect()->route('login');
    }

    $usuario = DB::table('usuarios')
        ->where('Id_Usuario', session('id_usuario'))
        ->first();

    $carrito = DB::table('carrito as c')
        ->join('productos as p', 'c.Id_Producto', '=', 'p.Id_Producto')
        ->where('c.Id_Usuario', session('id_usuario'))
        ->select(
            'c.id',
            'c.Id_Producto',
            'c.Cantidad',
            'c.Subtotal',
            'p.Nombre',
            'p.Precio',
            'p.Imagen'
        )
        ->get();

    $total = $carrito->sum('Subtotal');
    $totalPaquetes = $carrito->sum('Cantidad');

    return view('cliente.carrito', compact(
        'carrito',
        'total',
        'usuario',
        'totalPaquetes'
    ));
}
    /*
    |-------------------------
    | VERIFICAR SESIÓN
    |-------------------------
    */
    private function checkAuth()
    {
        if (!session('id_usuario')) {
            abort(redirect()->route('login'));
        }
    }

    /*
    |-------------------------
    | AGREGAR PRODUCTO
    |-------------------------
    */
    public function agregar($id)
    {
        $this->checkAuth();

        $producto = DB::table('productos')
            ->where('Id_Producto', $id)
            ->first();

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado');
        }

        $item = DB::table('carrito')
            ->where('Id_Usuario', session('id_usuario'))
            ->where('Id_Producto', $id)
            ->first();

        if ($item) {

            $nuevaCantidad = $item->Cantidad + 1;

            DB::table('carrito')
                ->where('id', $item->id)
                ->update([
                    'Cantidad' => $nuevaCantidad,
                    'Subtotal' => $nuevaCantidad * $producto->Precio,
                    'updated_at' => now()
                ]);

        } else {

            DB::table('carrito')->insert([
                'Id_Usuario' => session('id_usuario'),
                'Id_Producto' => $id,
                'Cantidad' => 1,
                'Subtotal' => $producto->Precio,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Agregado al carrito 🌹');
    }

    /*
    |-------------------------
    | FINALIZAR COMPRA
    |-------------------------
    */
    public function finalizar(Request $request)
    {
        $this->checkAuth();

        /*
        | VALIDACIÓN
        */
        $fecha = $request->Fecha_entrega;

            $hoy = date('Y-m-d');
            $min = date('Y-m-d', strtotime('+1 day'));
            $max = date('Y-m-d', strtotime('+7 days'));

            if (!$fecha) {
                return back()->with('error', 'Selecciona una fecha de entrega');
            }

            if ($fecha < $min) {
                return back()->with('error', 'La fecha debe ser a partir de mañana');
            }

            if ($fecha > $max) {
                return back()->with('error', 'Solo puedes agendar hasta 7 días');
}

        /*
        | CARRITO
        */
        $carrito = DB::table('carrito as c')
            ->join('productos as p', 'c.Id_Producto', '=', 'p.Id_Producto')
            ->where('c.Id_Usuario', session('id_usuario'))
            ->select('c.*', 'p.Precio')
            ->get();

        if ($carrito->isEmpty()) {
            return back()->with('error', 'El carrito está vacío');
        }

        /*
        | VALIDAR MAX 40 PRODUCTOS
        */
        if ($carrito->count() > 40) {
            return back()->with('error', 'Máximo 40 productos por pedido');
        }

        /*
        | VALIDAR MÍNIMO 7 PAQUETES
        */
        $totalPaquetes = $carrito->sum('Cantidad');

        if ($totalPaquetes < 7) {
            return back()->with('error', 'El pedido mínimo es de 7 paquetes');
        }

        /*
        | VALIDAR FECHA
        | - no pasada
        | - no hoy
        | - mínimo mañana
        | - máximo 7 días
        */
        $fecha = $request->Fecha_entrega;

        $hoy = date('Y-m-d');
        $max = date('Y-m-d', strtotime('+7 days'));

        if ($fecha <= $hoy) {
            return back()->with('error', 'La fecha debe ser posterior a hoy');
        }

        if ($fecha > $max) {
            return back()->with('error', 'Solo puedes agendar hasta 7 días');
        }

        /*
        | DIRECCIÓN
        */
        $usuario = DB::table('usuarios')
            ->where('Id_Usuario', session('id_usuario'))
            ->first();

        $direccion = $request->Direccion_entrega
            ?? ($usuario->Calle . ' ' . $usuario->Numero . ', ' .
                $usuario->Municipio . ', ' . $usuario->Estado . ', CP ' . $usuario->CP);

        /*
        | TOTAL
        */
        $total = $carrito->sum('Subtotal');

        /*
        | TRANSACCIÓN (CLAVE)
        */

        $ruta = null;

if($request->hasFile('Comprobante_pago')){

    $imagen = $request->file('Comprobante_pago');

    $nombre = time().'_'.$imagen->getClientOriginalName();

    $imagen->move(public_path('comprobantes'), $nombre);

    $ruta = 'comprobantes/'.$nombre;
}
        DB::beginTransaction();

        try {

            /*
            | PEDIDO
            */
            $idPedido = DB::table('pedidos')->insertGetId([
                'Id_Usuario' => session('id_usuario'),
                'Fecha_entrega' => $fecha,
                'Fecha_realizada' => date('Y-m-d'),
                'Total_pedido' => $total,
                'Cantidad_paquetes' => $totalPaquetes,
                'Estado_pedido' => 'Pendiente',
                'Tipo_entrega' => 'Domicilio',
                'metodo_pago' => $request->MetodoPago,
                'Direccion_entrega' => $direccion,
                'Observaciones' => $request->Observaciones,
                'Comprobante' => $ruta,
            ]);

            /*
            | PAGO
            */
            DB::table('pago')->insert([
                'Id_ped' => $idPedido,
                'metodo_pago' => $request->metodoPago,
                'Fecha_pago' => date('Y-m-d'),
                'monto' => $total,
                'Estado' => 'Pendiente',
                'comprobante' => $ruta
            ]);

            /*
            | PRODUCTOS PEDIDO
            */
            foreach ($carrito as $item) {

                DB::table('incluye')->insert([
                    'Id_ped' => $idPedido,
                    'Id_Producto' => $item->Id_Producto,
                    'Cantidad' => $item->Cantidad,
                    'Precio_unitario' => $item->Precio,
                    'Subtotal' => $item->Subtotal
                ]);
            }

            /*
            | LIMPIAR CARRITO
            */
            DB::table('carrito')
                ->where('Id_Usuario', session('id_usuario'))
                ->delete();

            DB::commit();

            return redirect()
                ->route('cliente.carrito')
                ->with('success', 'Pedido realizado correctamente 🌹');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
public function aumentar($id)
{
    // aumentar cantidad
    DB::table('carrito')
        ->where('id', $id)
        ->increment('Cantidad');

    // obtener carrito
    $item = DB::table('carrito')
        ->where('id', $id)
        ->first();

    // obtener producto
    $producto = DB::table('productos')
        ->where('Id_Producto', $item->Id_Producto)
        ->first();

    // actualizar subtotal
    DB::table('carrito')
        ->where('id', $id)
        ->update([
            'Subtotal' => $item->Cantidad * $producto->Precio
        ]);

    return redirect()->back();
}

public function disminuir($id)
{
    $item = DB::table('carrito')
        ->where('id', $id)
        ->first();

    if ($item) {

        if ($item->Cantidad > 1) {

            // disminuir
            DB::table('carrito')
                ->where('id', $id)
                ->decrement('Cantidad');

            // obtener actualizado
            $nuevo = DB::table('carrito')
                ->where('id', $id)
                ->first();

            // obtener producto
            $producto = DB::table('productos')
                ->where('Id_Producto', $nuevo->Id_Producto)
                ->first();

            // actualizar subtotal
            DB::table('carrito')
                ->where('id', $id)
                ->update([
                    'Subtotal' => $nuevo->Cantidad * $producto->Precio
                ]);

        } else {

            // eliminar si queda 0
            DB::table('carrito')
                ->where('id', $id)
                ->delete();
        }
    }

    return redirect()->back();
}
}