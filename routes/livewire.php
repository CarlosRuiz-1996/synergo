<?php

use App\Livewire\Catalogos\Estaciones;
use App\Livewire\CuentasPagar\ControlPagos;
use App\Livewire\Reportes\InventarioCombustible;
use App\Livewire\Reportes\InventarioCombustibleConsigna;
use App\Livewire\Reportes\InventarioCombustibletotal;
use App\Livewire\Reportes\VentasConsignas;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

// livewire
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('synergo/public/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('synergo/public/livewire/livewire.js', $handle);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('cuentas/pagar', ControlPagos::class)->name('cuentas.pagar');
    Route::get('catalogos/estaciones', Estaciones::class)->name('catalogos.estaciones');
    Route::get('reportes/reporteventasconsigna', VentasConsignas::class)->name('reportes.ventasconsignas');
    Route::get('reportes/inventarioCombustible', InventarioCombustible::class)->name('reportes.inventarioCombustible');
    Route::get('reportes/inventarioCombustibletotal', InventarioCombustibletotal::class)->name('reportes.inventarioCombustibletotal');
    Route::get('reportes/inventarioCombustibleconsigna', InventarioCombustibleConsigna::class)->name('reportes.inventarioCombustibleconsigna');

    

});
