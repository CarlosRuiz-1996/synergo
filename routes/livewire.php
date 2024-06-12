<?php 
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

// livewire
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/livewire/livewire.js', $handle);
});

?>