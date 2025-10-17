<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\RutasController;

Route::get('/', [RutasController::class, 'index']);
Route::get('/registrar',[PacienteController::class,'registrarpaciente']);
