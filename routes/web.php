<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\RecepcionistaController;

Route::get('/', [RutasController::class, 'index'])->name('/');

Route::get('/registrar',[PacienteController::class,'registrarpaciente'])->name('pacientes.registrarpaciente');
Route::post('/registrar',[PacienteController::class,'store'])->name('pacientes.store');

Route::get('/citasprogramadas', [PacienteController::class, 'listado_citaspro'])->name('citasprogramadas');

Route::get('/agendarcitas', [PacienteController::class, 'agendar_Citasonline'])->name('agendarcitas');

Route::get('/loginpaciente', [PacienteController::class, 'loginp'])->name('pacientes.loginp');
Route::get('/recuperar', [PacienteController::class, 'enviar_codigo_recuperacion'])->name('pacientes.enviar_codigo_recuperacion');
Route::post('/loginpaciente', [PacienteController::class, 'login'])->name('pacientes.login');

Route::post('/logout', [PacienteController::class, 'logout'])->name('pacientes.logout');

//RUTAS RECEPCIONISTA
Route::get('/busquedaexpediente',[RecepcionistaController::class,'buscarExpediente'])->name('recepcionista.busquedaexpediente');
Route::get('/informacion', [PacienteController::class, 'informacion'])->name('pacientes.informacion_Clinica');
