<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\EmpleadoController;

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

Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis-citas');
Route::post('/cancelar-cita/{id}', [CitaController::class, 'cancelarCita'])->name('citas.cancelar');
Route::post('/reprogramar-cita/{id}', [CitaController::class, 'reprogramarCita'])->name('citas.reprogramar');

// Rutas para expedientes
Route::get('/expedientes/crear', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear');
Route::get('/expedientes/crear/{paciente_id}', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear.paciente');
Route::post('/expedientes/guardar', [ExpedienteController::class, 'store'])->name('expedientes.guardar');
Route::get('/expedientes/lista', [ExpedienteController::class, 'lista'])->name('expedientes.lista');

// Rutas para empleados
Route::get('/empleados/crear', [EmpleadoController::class, 'crear'])->name('empleados.crear');
Route::post('/empleados/guardar', [EmpleadoController::class, 'store'])->name('empleados.guardar');
Route::get('/empleados/lista', [EmpleadoController::class, 'lista'])->name('empleados.lista');
