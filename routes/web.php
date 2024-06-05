<?php

use App\Http\Controllers\CajasController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// livewire
Route::get('/reportes/cajas/{request?}', [CajasController::class,'reporte'])->name('reporte.cajas');

include('livewire.php');
