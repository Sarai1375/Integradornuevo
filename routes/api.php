<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\PedidoApiController;
use App\Http\Controllers\Api\PromocionApiController;
use App\Http\Controllers\Api\ProveedorApiController;
use App\Http\Controllers\Api\UsuarioApiController;
use App\Http\Controllers\Api\InventarioApiController;
use App\Http\Controllers\Api\EncuestaApiController;
use App\Http\Controllers\Api\CarritoApiController;
use App\Http\Controllers\Api\GeminiApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Endpoints REST en JSON para los recursos principales del proyecto.
| Para proteger los endpoints de escritura puedes envolverlos con
| ->middleware('auth:sanctum') una vez configurado Sanctum.
|
*/

Route::get('/ping', fn () => response()->json([
    'status' => 'ok',
    'app' => config('app.name'),
    'time' => now()->toIso8601String(),
]));

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Productos
Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoApiController::class, 'index']);
    Route::get('/{id}', [ProductoApiController::class, 'show'])->whereNumber('id');
    Route::post('/', [ProductoApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [ProductoApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [ProductoApiController::class, 'destroy'])->whereNumber('id');
});

// Pedidos
Route::prefix('pedidos')->group(function () {
    Route::get('/', [PedidoApiController::class, 'index']);
    Route::get('/{id}', [PedidoApiController::class, 'show'])->whereNumber('id');
    Route::post('/', [PedidoApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [PedidoApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [PedidoApiController::class, 'destroy'])->whereNumber('id');
});

// Promociones
Route::prefix('promociones')->group(function () {
    Route::get('/', [PromocionApiController::class, 'index']);
    Route::get('/{id}', [PromocionApiController::class, 'show'])->whereNumber('id');
    Route::post('/', [PromocionApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [PromocionApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [PromocionApiController::class, 'destroy'])->whereNumber('id');
});

// Proveedores
Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorApiController::class, 'index']);
    Route::get('/{id}', [ProveedorApiController::class, 'show'])->whereNumber('id');
    Route::post('/', [ProveedorApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [ProveedorApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [ProveedorApiController::class, 'destroy'])->whereNumber('id');
});

// Usuarios + alias /clientes (rol_id = 2)
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioApiController::class, 'index']);
    Route::get('/{id}', [UsuarioApiController::class, 'show'])->whereNumber('id');
    Route::post('/', [UsuarioApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [UsuarioApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [UsuarioApiController::class, 'destroy'])->whereNumber('id');
});
Route::get('/clientes', [UsuarioApiController::class, 'clientes']);

// Inventario (productos+materiales+proveedores resumen y CRUD de material)
Route::prefix('inventario')->group(function () {
    Route::get('/', [InventarioApiController::class, 'resumen']);

    Route::get('/materiales', [InventarioApiController::class, 'indexMateriales']);
    Route::get('/materiales/{id}', [InventarioApiController::class, 'showMaterial'])->whereNumber('id');
    Route::post('/materiales', [InventarioApiController::class, 'storeMaterial']);
    Route::match(['put', 'patch'], '/materiales/{id}', [InventarioApiController::class, 'updateMaterial'])->whereNumber('id');
    Route::delete('/materiales/{id}', [InventarioApiController::class, 'destroyMaterial'])->whereNumber('id');
});

// Encuesta
Route::prefix('encuestas')->group(function () {
    Route::get('/', [EncuestaApiController::class, 'index']);
    Route::post('/', [EncuestaApiController::class, 'store']);
});

// Carrito
Route::prefix('carrito')->group(function () {
    Route::get('/', [CarritoApiController::class, 'index']);
    Route::post('/', [CarritoApiController::class, 'store']);
    Route::match(['put', 'patch'], '/{id}', [CarritoApiController::class, 'update'])->whereNumber('id');
    Route::delete('/{id}', [CarritoApiController::class, 'destroy'])->whereNumber('id');
});

// Gemini (IA)
Route::post('/gemini/chat', [GeminiApiController::class, 'chat']);
