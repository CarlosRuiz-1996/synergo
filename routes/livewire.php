<?php

use App\Livewire\Catalogos\Estaciones;
use App\Livewire\CuentasPagar\ControlPagos;
use App\Livewire\CuentasPagar\Controlpagosdos;
use App\Livewire\Reportes\InventarioCombustible;
use App\Livewire\Reportes\InventarioCombustibleConsigna;
use App\Livewire\Reportes\InventarioCombustibletotal;
use App\Livewire\Reportes\VentasConsignas;
use App\Livewire\Tesoreria\Tesoreria;
use App\Livewire\UserCrud;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Livewire\Catalogos\Aceites;
use App\Livewire\Catalogos\HomeCtg;

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
    Route::get('/usuarios', UserCrud::class)->name('usuarios');
    Route::get('cuentas/pagardos', Controlpagosdos::class)->name('cuentas.pagardos');
    Route::get('cuentas/tesoreria', Tesoreria::class)->name('cuentas.tesoreria');
    Route::get('catalogos/aceites',Aceites::class)->name('ctg.aceites');

    Route::get('/catalogos', HomeCtg::class)->name('ctg.index');


});
