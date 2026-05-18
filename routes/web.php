<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\Reportescontroller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\CodigoPostalController;

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    session()->flush();

    session()->invalidate();

    session()->regenerateToken();

    Auth::logout();

    return redirect('/inicio');

})->name('logout');

/*
|--------------------------------------------------------------------------
| PÁGINA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('inicio');
});

Route::get('/inicio', function () {
    return view('cpanel.inicio');
})->name('inicio');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('cpanel.usuarios.form');
})->name('register');

// Registro normal
Route::post('/registro', [UsuariosController::class, 'store'])
    ->name('usuarios.store');

// Registro desde admin
Route::post('/admin/usuarios/crear', [UsuariosController::class, 'storeAdmin'])
    ->name('usuarios.storeAdmin');
/*

|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'login'])
    ->name('login');

Route::post('/login', [LoginController::class, 'loginProcess'])
    ->name('login.process');

/*
|--------------------------------------------------------------------------
| BIENVENIDA
|--------------------------------------------------------------------------
*/

Route::get('/bienvenido', [LoginController::class, 'bienvenido'])
    ->name('bienvenido');

/*
|--------------------------------------------------------------------------
| TWO FACTOR AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/twofactor', [TwoFactorController::class, 'index'])
    ->name('twofactor.index');

Route::post('/twofactor/verify', [TwoFactorController::class, 'verify'])
    ->name('twofactor.verify');

Route::post('/twofactor/send', [TwoFactorController::class, 'sendCode'])
    ->name('twofactor.send');

/*
|--------------------------------------------------------------------------
| PANEL DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->group(function () {

    Route::get('/admon', function () {

        if (!session('usuario_logueado')) {

            return redirect()->route('login');

        }

        return view('cpanel.inicio');

    })->name('admon.inicio');

    Route::resource('admon/usuarios', UsuariosController::class);

    Route::delete(
        'usuarios/eliminar-seleccion',
        [UsuariosController::class, 'eliminarSeleccion']
    )->name('usuarios.eliminar-seleccion');

    Route::get('/usuarios/eliminar/{id}', [UsuariosController::class, 'eliminar'])
    ->name('usuarios.eliminar');
Route::post('/usuarios/eliminar/{id}',
    [UsuariosController::class, 'eliminar'])
    ->name('usuarios.eliminar');

    //eliminarseleccion,protege usuarios
   Route::post('/usuarios/eliminar-seleccion',
    [UsuariosController::class, 'eliminarSeleccion'])
    ->name('usuarios.eliminar-seleccion');
    Route::get(
        '/usuarios/graficar',
        [UsuariosController::class, 'graficar']
    )->name('usuarios.graficar');

    Route::get('/usuarios', [UsuariosController::class, 'index'])
        ->name('usuarios.index');

    Route::resource('proveedores', ProveedorController::class);

    Route::get('/cpanel/indexproveedores', [ProveedorController::class, 'index'])
    ->name('proveedores.index');


    Route::get(
        'admon/reportes/pdf',
        [Reportescontroller::class, 'GenerarPDF']
    )->name('reporte.pdf');

    Route::get(
        '/reporte-excel',
        [Reportescontroller::class, 'ExportarExcel']
    )->name('reporte.excel');

});

/*
|--------------------------------------------------------------------------
| ENCUESTA
|--------------------------------------------------------------------------
*/

Route::get('/encuesta-satisfaccion', [EncuestaController::class, 'index'])
    ->name('encuesta.index');

/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

Route::get('/cliente/inicio', [ClienteController::class, 'index'])
    ->name('cliente.inicio');



Route::get('/cliente/carrito', [CarritoController::class, 'index'])
    ->name('cliente.carrito');

Route::get('/cliente/pedidos', [ClienteController::class, 'pedidos'])
    ->name('cliente.pedidos');



/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/

Route::resource('productos', ProductoController::class);

/*
/*
|----------------------------------------------------------------------
| PROMOCIONES
|----------------------------------------------------------------------
*/
// 🟢 CLIENTE - ver promociones activas
Route::get(
    '/cliente/promociones',
    [PromocionesController::class, 'clientePromociones']
)->name('cliente.promociones');
// 🔵 ADMIN - listado
Route::get(
    '/admin/promociones',
    [PromocionesController::class, 'adminIndex']
)->name('admin.promociones');
// 🔵 ADMIN - crear
Route::get(
    '/admin/promociones/create',
    [PromocionesController::class, 'create']
)->name('admin.promociones.create');
Route::post(
    '/admin/promociones/store',
    [PromocionesController::class, 'store']
)->name('admin.promociones.store');
// 🔵 ADMIN - editar
Route::get(
    '/admin/promociones/edit/{id}',
    [PromocionesController::class, 'edit']
)->name('admin.promociones.edit');
Route::post(
    '/admin/promociones/update/{id}',
    [PromocionesController::class, 'update']
)->name('admin.promociones.update');
// 🔵 ADMIN - eliminar
Route::delete(
    '/admin/promociones/delete/{id}',
    [PromocionesController::class, 'destroy']
)->name('admin.promociones.delete');
// 🟡 CARRITO (NO TOCAR)
Route::post(
    '/carrito/agregar/{id}',
    [CarritoController::class, 'agregar']
)->name('cliente.carrito.agregar');
/*
|--------------------------------------------------------------------------
| PEDIDOS
|--------------------------------------------------------------------------
*/

Route::get('/pedidos', [PedidoController::class, 'index'])
    ->name('pedidos.index');

/*
|--------------------------------------------------------------------------
| CARRITO
|--------------------------------------------------------------------------
*/

Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
    ->name('carrito.eliminar');

Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])
    ->name('carrito.finalizar');

    //inventario

    Route::get('/inventario', [InventarioController::class, 'index'])
    ->name('inventario.index');
    Route::post('/material', [InventarioController::class, 'storeMaterial'])
    ->name('material.store');
   
    Route::put('/material/{id}', [InventarioController::class, 'updateMaterial'])->name('material.update');
    Route::delete('/material/{id}', [InventarioController::class, 'destroyMaterial'])->name('material.destroy');

    //Recuperar contraseña 
    Route::get('/forgot-password', function () {
    return view('cpanel.auth.forgot');
    });

    Route::post('/forgot-password', [App\Http\Controllers\UsuariosController::class, 'resetPassword'])
        ->name('password.reset');


   Route::get('/cliente/perfil',
    [ClienteController::class, 'perfil'])
    ->name('cliente.perfil');

    Route::post('/cliente/perfil/actualizar',
    [ClienteController::class, 'actualizarPerfil'])
    ->name('cliente.perfil.actualizar');

 

Route::post('/pedido/guardar',
    [PedidoController::class, 'guardar']
)->name('pedido.guardar');

Route::post(
    '/carrito/aumentar/{id}',
    [CarritoController::class, 'aumentar']
)->name('carrito.aumentar');

Route::post(
    '/carrito/disminuir/{id}',
    [CarritoController::class, 'disminuir']
)->name('carrito.disminuir');

/*
|--------------------------------------------------------------------------
| ADMIN PEDIDOS
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/pedidos',
    [AdminPedidoController::class, 'index']
)->name('admin.pedidos');

Route::post(
    '/admin/pedido/aprobar/{id}',
    [AdminPedidoController::class, 'aprobar']
)->name('admin.pedido.aprobar');

Route::post(
    '/admin/pedido/rechazar/{id}',
    [AdminPedidoController::class, 'rechazar']
)->name('admin.pedido.rechazar');

Route::post(
    '/admin/pedido/enviado/{id}',
    [AdminPedidoController::class, 'enviado']
)->name('admin.pedido.enviado');

Route::post(
    '/admin/pedido/entregado/{id}',
    [AdminPedidoController::class, 'entregado']
)->name('admin.pedido.entregado');

Route::prefix('admin')->group(function () {

    Route::get('/pedidos', [AdminPedidoController::class, 'index'])
        ->name('admin.pedidos');

    Route::post('/pedido/{id}/aprobar', [AdminPedidoController::class, 'aprobar'])
        ->name('admin.pedido.aprobar');

    Route::post('/pedido/{id}/rechazar', [AdminPedidoController::class, 'rechazar'])
        ->name('admin.pedido.rechazar');

    Route::post('/pedido/{id}/enviado', [AdminPedidoController::class, 'enviado'])
        ->name('admin.pedido.enviado');

    Route::post('/pedido/{id}/entregado', [AdminPedidoController::class, 'entregado'])
        ->name('admin.pedido.entregado');

});
Route::get('/cliente/pedidos/{id}', [PedidoController::class, 'detalle'])
    ->name('cliente.pedidos.detalle');

    Route::post('/admin/pedidos/estado/{id}', [AdminPedidoController::class, 'cambiarEstado'])
    ->name('admin.pedidos.estado');


 //CP

Route::get('/importar-cp', [CodigoPostalController::class, 'importar']);

Route::get('/buscar-cp/{cp}', [CodigoPostalController::class, 'buscar']);


Route::post('/pedido/aprobar/{id}',
    [AdminPedidoController::class, 'aprobar'])
    ->name('pedido.aprobar');

Route::post('/pedido/rechazar/{id}',
    [AdminPedidoController::class, 'rechazar'])
    ->name('pedido.rechazar');