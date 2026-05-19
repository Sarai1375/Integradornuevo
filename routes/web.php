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
use App\Http\Controllers\GeminiChatController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (sin autenticación)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('inicio');
});

Route::get('/inicio', function () {
    return view('cpanel.inicio');
})->name('inicio');

// Registro
Route::get('/register', function () {
    return view('cpanel.usuarios.form');
})->name('register');

Route::post('/registro', [UsuariosController::class, 'store'])
    ->name('usuarios.store');

// Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// Two Factor (parte del flujo de login, debe ser público)
Route::get('/twofactor', [TwoFactorController::class, 'index'])->name('twofactor.index');
Route::post('/twofactor/verify', [TwoFactorController::class, 'verify'])->name('twofactor.verify');
Route::post('/twofactor/send', [TwoFactorController::class, 'sendCode'])->name('twofactor.send');

// Recuperación de contraseña
Route::get('/forgot-password', function () {
    return view('cpanel.auth.forgot');
});
Route::post('/forgot-password', [UsuariosController::class, 'resetPassword'])
    ->name('password.reset');

// Códigos postales (consulta pública para formularios)
Route::get('/buscar-cp/{cp}', [CodigoPostalController::class, 'buscar']);

// Chat IA (Gemini)
Route::get('/chat-ia', [GeminiChatController::class, 'index'])->name('chat.gemini');
Route::post('/chat-ia/send', [GeminiChatController::class, 'send'])->name('chat.gemini.send');

// Logout
Route::post('/logout', function () {
    session()->flush();
    session()->invalidate();
    session()->regenerateToken();
    Auth::logout();
    return redirect('/inicio');
})->name('logout');


/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS (cualquier rol logueado)
|--------------------------------------------------------------------------
*/

Route::middleware(['autenticado'])->group(function () {

    Route::get('/bienvenido', [LoginController::class, 'bienvenido'])
        ->name('bienvenido');

    Route::get('/encuesta-satisfaccion', [EncuestaController::class, 'index'])
        ->name('encuesta.index');

});


/*
|--------------------------------------------------------------------------
| RUTAS SOLO CLIENTE
|--------------------------------------------------------------------------
*/

Route::middleware(['autenticado', 'rol:cliente'])->group(function () {

    // Inicio cliente
    Route::get('/cliente/inicio', [ClienteController::class, 'index'])
        ->name('cliente.inicio');

    // Perfil
    Route::get('/cliente/perfil', [ClienteController::class, 'perfil'])
        ->name('cliente.perfil');
    Route::post('/cliente/perfil/actualizar', [ClienteController::class, 'actualizarPerfil'])
        ->name('cliente.perfil.actualizar');

    // Pedidos del cliente
    Route::get('/cliente/pedidos', [ClienteController::class, 'pedidos'])
        ->name('cliente.pedidos');
    Route::get('/cliente/pedidos/{id}', [PedidoController::class, 'detalle'])
        ->name('cliente.pedidos.detalle');

    // Promociones cliente
    Route::get('/cliente/promociones', [PromocionesController::class, 'clientePromociones'])
        ->name('cliente.promociones');

    // Carrito
    Route::get('/cliente/carrito', [CarritoController::class, 'index'])
        ->name('cliente.carrito');
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
        ->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
        ->name('carrito.eliminar');
    Route::post('/carrito/aumentar/{id}', [CarritoController::class, 'aumentar'])
        ->name('carrito.aumentar');
    Route::post('/carrito/disminuir/{id}', [CarritoController::class, 'disminuir'])
        ->name('carrito.disminuir');
    Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])
        ->name('carrito.finalizar');

    // Pedido
    Route::post('/pedido/guardar', [PedidoController::class, 'guardar'])
        ->name('pedido.guardar');

});


/*
|--------------------------------------------------------------------------
| RUTAS SOLO ADMIN / EMPLEADO
|--------------------------------------------------------------------------
*/

Route::middleware(['autenticado', 'rol:admin,empleado'])->group(function () {

    // Panel admin
    Route::get('/admon', function () {
        return view('cpanel.inicio');
    })->name('admon.inicio');

    // Usuarios
    Route::resource('admon/usuarios', UsuariosController::class);
    Route::get('/usuarios', [UsuariosController::class, 'index'])
        ->name('usuarios.index');
    Route::get('/usuarios/graficar', [UsuariosController::class, 'graficar'])
        ->name('usuarios.graficar');
    Route::get('/usuarios/eliminar/{id}', [UsuariosController::class, 'eliminar'])
        ->name('usuarios.eliminar.get');
    Route::post('/usuarios/eliminar/{id}', [UsuariosController::class, 'eliminar'])
        ->name('usuarios.eliminar');
    Route::post('/usuarios/eliminar-seleccion', [UsuariosController::class, 'eliminarSeleccion'])
        ->name('usuarios.eliminar-seleccion');
    Route::delete('/usuarios/eliminar-seleccion', [UsuariosController::class, 'eliminarSeleccion'])
        ->name('usuarios.eliminar-seleccion.delete');

    // Registro desde admin
    Route::post('/admin/usuarios/crear', [UsuariosController::class, 'storeAdmin'])
        ->name('usuarios.storeAdmin');

    // Proveedores
    Route::resource('proveedores', ProveedorController::class);
    Route::get('/cpanel/indexproveedores', [ProveedorController::class, 'index'])
        ->name('proveedores.index.alt');

    // Productos
    Route::resource('productos', ProductoController::class);

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])
        ->name('inventario.index');
    Route::post('/material', [InventarioController::class, 'storeMaterial'])
        ->name('material.store');
    Route::put('/material/{id}', [InventarioController::class, 'updateMaterial'])
        ->name('material.update');
    Route::delete('/material/{id}', [InventarioController::class, 'destroyMaterial'])
        ->name('material.destroy');

    // Reportes
    Route::get('admon/reportes/pdf', [Reportescontroller::class, 'GenerarPDF'])
        ->name('reporte.pdf');
    Route::get('/reporte-excel', [Reportescontroller::class, 'ExportarExcel'])
        ->name('reporte.excel');

    // Promociones (admin)
    Route::get('/admin/promociones', [PromocionesController::class, 'adminIndex'])
        ->name('admin.promociones');
    Route::get('/admin/promociones/create', [PromocionesController::class, 'create'])
        ->name('admin.promociones.create');
    Route::post('/admin/promociones/store', [PromocionesController::class, 'store'])
        ->name('admin.promociones.store');
    Route::get('/admin/promociones/edit/{id}', [PromocionesController::class, 'edit'])
        ->name('admin.promociones.edit');
    Route::post('/admin/promociones/update/{id}', [PromocionesController::class, 'update'])
        ->name('admin.promociones.update');
    Route::delete('/admin/promociones/delete/{id}', [PromocionesController::class, 'destroy'])
        ->name('admin.promociones.delete');

    // Pedidos admin
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
        Route::post('/pedidos/estado/{id}', [AdminPedidoController::class, 'cambiarEstado'])
            ->name('admin.pedidos.estado');
    });

    // Pedidos generales
    Route::get('/pedidos', [PedidoController::class, 'index'])
        ->name('pedidos.index');

    // Importar CP (mantenimiento)
    Route::get('/importar-cp', [CodigoPostalController::class, 'importar']);

});
