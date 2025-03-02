<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CajasController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\descargarComprobateXmloPDF;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/reportes/cajas', [CajasController::class, 'reporte'])->name('reporte.cajas');
    Route::get('/reportes/ventas', [CajasController::class, 'reporteVentas'])->name('reporte.ventas');
    Route::get('/reportes/ComprasConsignas', [CajasController::class, 'reporteComprasConsignas'])->name('reporte.ComprasConsignas');
    Route::get('/reportes/reporteResumenCompras', [CajasController::class, 'reporteResumenCompras'])->name('reporte.reporteResumenCompras');

    Route::get('/subir-archivo', [FacturaController::class, 'mostrarFormularioSubida'])->name('subir-archivo');
    Route::post('/procesar-archivos', [FacturaController::class, 'procesarArchivos'])->name('procesar-archivos');


    Route::get('/descargaComprobante', [descargarComprobateXmloPDF::class, 'descargarComprobateXmloPDF'])->name('reporte.descargarComprobateXmloPDF');
    Route::get('/login2', [login::class, 'index'])->name('login2.index');


    Route::get('administrador', [AdminController::class, 'index'])->name('admin.home');
});

// livewire
include('livewire.php');
