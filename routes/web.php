<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubModuloController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//#region rutas para renderizar
Route::middleware('guest.block')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Inicio');
    })->name('inicio');

    Route::get('/productos', function() {
        return Inertia::render('Catalogo');
    })->name('catalogo');

    Route::get('/sobre-nosotros', function () {
        return Inertia::render('Nosotros');
    })->name('nosotros');
});
//#endregion


// Rutas libres (acceso sin importar autenticación)
Route::get('/cliente/obtener', [ClienteController::class, 'index'])->name('cliente.index');
Route::get('/catalogo/listar', [ProductoController::class, 'list'])->name('catalogo.list');

Route::middleware(['auth.home', 'verified'])->group(function () {

    // Panel principal
    Route::get('/principal', function () {
        return Inertia::render('Modules/LoadModules');
    })->name('principal');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/cliente/crear', [ClienteController::class, 'store'])->name('cliente.store');

    // OCR / AI
    Route::post('/parse-factura', [AiController::class, 'parseFactura']);
    Route::post('/extraer-datos-factura', [AiController::class, 'convertirImagenATexto']);
    Route::post('/extraer-datos-facturas', [AiController::class, 'convertirMultiplesImagenesATexto']);

    
    #region modulos
    Route::get('/modulo/listar', [ModuloController::class, 'index'])->name('modulo.index');
    Route::post('/modulo/crear', [ModuloController::class, 'store'])->name('modulo.store');
    #endregion

    #region submodulos
    Route::get('/submodulo/listar', [SubModuloController::class, 'index'])->name('submodulo.index');
    #endregion

    #region productos
    Route::post('/producto/crear', [ProductoController::class, 'store'])->name('producto.store');
    Route::get('/producto/listar', [ProductoController::class, 'index'])->name('producto.index');
    #endregion
    
    #region marcas
    Route::post('/marca/crear', [MarcaController::class, 'store'])->name('marca.store');
    Route::get('/marca/listar', [MarcaController::class, 'index'])->name('marca.index');
    #endregion

    #region categorias
    Route::post('/categoria/crear', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::get('/categoria/listar', [CategoriaController::class, 'index'])->name('categoria.index');
    #endregion

    #region entrada producto
    Route::post('/entrada-producto/crear', [InventarioController::class, 'store'])->name('entrada.store');
    #endregion

});

require __DIR__.'/auth.php';
