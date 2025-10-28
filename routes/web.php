<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginempleadoController;
use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', [RutasController::class, 'index'])->name('/');
Route::get('/promociones', [RutasController::class, 'index'])->name('promociones.index');

Route::get('/registrar',[PacienteController::class,'registrarpaciente'])->name('pacientes.registrarpaciente');
Route::post('/registrar',[PacienteController::class,'store'])->name('pacientes.store');


Route::get('/agendarcitas', [PacienteController::class, 'agendar_Citasonline'])->name('agendarcitas');

Route::get('/loginpaciente', [PacienteController::class, 'loginp'])->name('pacientes.loginp');
Route::get('/recuperar', [PacienteController::class, 'enviar_codigo_recuperacion'])->name('pacientes.enviar_codigo_recuperacion');
Route::post('/recuperar', [PacienteController::class, 'enviarCodigoRecuperacion'])->name('enviarCodigoRecuperacion');
Route::get('/restablecer/{token}', [PacienteController::class, 'cambio_contra'])->name('pacientes.cambio_contra');
Route::post('/restablecer', [PacienteController::class, 'actualizarContra'])->name('password.update');
Route::post('/loginpaciente', [PacienteController::class, 'login'])->name('pacientes.login');

Route::post('/logout', [PacienteController::class, 'logout'])->name('pacientes.logout');

Route::get('/informacion', [PacienteController::class, 'informacion'])->name('pacientes.informacion_Clinica');
Route::get('/comentarios', [ComentarioController::class, 'index'])->name('comentarios.index');
Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');


Route::get('/doctores', [DoctorController::class, 'visualizacion_Doctores'])->name('pacientes.visualizacion_Doctores');

//RUTAS RECEPCIONISTA
Route::get('/loginempleado', [loginempleadoController::class, 'loginempleado'])->name('empleados.loginempleado');
Route::post('/loginempleados', [loginempleadoController::class, 'login'])->name('empleados.login');
Route::post('/logout', [LoginempleadoController::class, 'logout'])->name('empleados.logout');
Route::get('/busquedaexpediente',[RecepcionistaController::class,'buscarExpediente'])->name('recepcionista.busquedaexpediente');
Route::get('/informacion', [PacienteController::class, 'informacion'])->name('pacientes.informacion_Clinica');


Route::get('/recepcionista/citas', [CitaController::class, 'index'])->name('listadocitas');



//citas
Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis-citas');
Route::post('/cancelar-cita/{id}', [CitaController::class, 'cancelarCita'])->name('citas.cancelar');
Route::post('/reprogramar-cita/{id}', [CitaController::class, 'reprogramarCita'])->name('citas.reprogramar');
Route::post('/citas/{id}/confirmar', [CitaController::class, 'confirmarCita'])->name('citas.confirmar');
Route::post('/citas/guardar', [CitaController::class, 'guardarDesdeCalendario'])->name('citas.guardar');
Route::post('/citas/guardar-calendario', [CitaController::class, 'guardarDesdeCalendario'])->name('citas.guardar.calendario');






// Rutas para expedientes
Route::get('/expedientes/crear', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear');
Route::get('/expedientes/crear/{paciente_id}', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear.paciente');
Route::post('/expedientes/guardar', [ExpedienteController::class, 'store'])->name('expedientes.guardar');
Route::get('/expedientes/lista', [ExpedienteController::class, 'lista'])->name('expedientes.lista');

// Rutas para empleados
Route::get('/empleados/crear', [EmpleadoController::class, 'crear'])->name('empleados.crear');
Route::post('/empleados/guardar', [EmpleadoController::class, 'store'])->name('empleados.guardar');
Route::get('/empleados/lista', [EmpleadoController::class, 'lista'])->name('empleados.lista');
