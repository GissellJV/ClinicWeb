<?php

use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EnfermeriaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\AsignacionHabitacionController;
use App\Http\Controllers\VisualizacionHabitacionController;
use App\Http\Controllers\DoctorHabitacionController; // Nuevo
use \App\Http\Controllers\EnviarDoctorController;
use App\Http\Controllers\PromocionController;

Route::get('/', [RutasController::class, 'index'])->name('/');

Route::get('/promociones', [RutasController::class, 'index'])->name('promociones.index');

Route::get('/registrar',[PacienteController::class,'registrarpaciente'])->name('pacientes.registrarpaciente');
Route::post('/registrar',[PacienteController::class,'store'])->name('pacientes.store');


Route::get('/agendarcitas', [PacienteController::class, 'agendar_Citasonline'])->name('agendarcitas');

//Route::get('/loginpaciente', [PacienteController::class, 'loginp'])->name('pacientes.loginp');
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

//para calificar como paciente
Route::post('/calificar', [CalificacionController::class, 'store'])->name('calificar');

// Rutas adicionales opcionales
Route::get('/doctor/{id}/calificaciones', [CalificacionController::class, 'verCalificaciones'])->name('doctor.calificaciones');
Route::put('/calificacion/{id}', [CalificacionController::class, 'update'])->name('calificacion.update');
Route::delete('/calificacion/{id}', [CalificacionController::class, 'destroy'])->name('calificacion.destroy');


//RUTAS RECEPCIONISTA
Route::get('/login', [LoginController::class, 'loginempleado'])->name('inicioSesion');
Route::post('/login',[LoginController::class, 'login'])->name('login.sesion');
Route::post('/logoutE', [LoginController::class, 'logout'])->name('empleados.logout');
Route::get('/busquedaexpediente',[RecepcionistaController::class,'buscarExpediente'])->name('recepcionista.busquedaexpediente');
Route::get('/informacion', [PacienteController::class, 'informacion'])->name('pacientes.informacion_Clinica');


Route::get('/recepcionista/citas', [CitaController::class, 'index'])->name('listadocitas');
Route::get('/citas/agendar', [CitaController::class, 'agendar'])->name('citas.agendar');
Route::post('/citas/guardar', [CitaController::class, 'guardarDesdeCalendario'])->name('citas.guardar');
Route::get('/citas/horarios/{doctorId}/{fecha}', [CitaController::class, 'obtenerHorarios'])->name('citas.horarios');

//registro pacientes
Route::get('/asistenciapaciente', [RecepcionistaController::class, 'registroPaciente'])->name('recepcionista.registroPaciente');

//visualizacion de turnos doctores
Route::get('/turnos', [TurnoController::class, 'index'])->name('recepcionista.index');
Route::post('/turnos', [TurnoController::class, 'store'])->name('recepcionista.store');

//citas
Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('citas.mis-citas');
Route::post('/cancelar-cita/{id}', [CitaController::class, 'cancelarCita'])->name('citas.cancelar');
Route::post('/reprogramar-cita/{id}', [CitaController::class, 'reprogramarCita'])->name('citas.reprogramar');
Route::post('/citas/{id}/confirmar', [CitaController::class, 'confirmarCita'])->name('citas.confirmar');



// Rutas para expedientes
Route::get('/expedientes/crear', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear');
Route::get('/expedientes/crear/{paciente_id}', [ExpedienteController::class, 'crearExpediente'])->name('expedientes.crear.paciente');
Route::post('/expedientes/guardar', [ExpedienteController::class, 'store'])->name('expedientes.guardar');
Route::get('/ver-expediente/{id}', [ExpedienteController::class, 'verExpediente'])->name('expedientes.visualizar');

// rutas de agregar datos vitales del expediente y de actualizar consulta
Route::post('/expedientes/{id}/actualizar-signos', [ExpedienteController::class, 'actualizarSignos'])->name('expedientes.actualizarSignos');
Route::post('/expedientes/{id}/actualizar-consulta', [ExpedienteController::class, 'actualizarConsulta'])->name('expedientes.actualizarConsulta');
Route::post('/expedientes/{id}/actualizar-historial', [ExpedienteController::class, 'actualizarHistorial'])->name('expedientes.actualizarHistorial');


// Rutas para empleados
Route::get('/empleados/crear', [EmpleadoController::class, 'crear'])->name('empleados.crear');
Route::post('/empleados/guardar', [EmpleadoController::class, 'store'])->name('empleados.guardar');
Route::get('/empleados/lista', [EmpleadoController::class, 'lista'])->name('empleados.lista');





Route::get('/recetamedica', [RecetaController::class, 'recetamedica'])->name('recetamedica');
Route::post('/recetamedica/pdf', [RecetaController::class, 'generarPDF'])->name('receta.pdf');

//Ruta para doctores
Route::get('/doctor-principal', [DoctorController::class, 'receta'])->name('doctor.receta');
Route::get('/recepcionista/doctores-expediente/{departamento}', [DoctorController::class, 'getDoctoresPorEspecialidad']);
Route::get('/doctor/expedientes-recibidos', [DoctorController::class, 'expedientesRecibidos'])->name('doctor.expedientesRecibidos');
Route::get('/doctor/expediente/{id}', [DoctorController::class, 'verExpediente'])->name('expediente.ver');


//Ruta para enfermeros
Route::get('/enfermeria-principal', [EnfermeriaController::class, 'principal'])->name('enfermeria.principal');
Route::get('/enfermeria/medicamentos', [PacienteController::class, 'medicamentosPorPaciente'])->name('pacientes.medicamentos');
Route::post('/asignar-medicamento', [PacienteController::class, 'asignarMedicamento'])->name('asignar.medicamento');


//Rol Turno de enfermeros
Route::get('/enfermeria/turnos', [EnfermeriaController::class, 'rolTurno'])->name('enfermeria.turnos');


// Agendar citas - Recepcionista
Route::get('/recepcionista/agendar-cita', [CitaController::class, 'crearCitaRecepcionista'])->name('recepcionista.citas.crear');
Route::post('/recepcionista/agendar-cita', [CitaController::class, 'guardarCitaRecepcionista'])->name('recepcionista.citas.guardar');
Route::get('/recepcionista/doctores-especialidad/{departamento}', [CitaController::class, 'getDoctoresPorEspecialidad']);
Route::post('/recepcionista/verificar-disponibilidad', [CitaController::class, 'verificarDisponibilidad']);

// ver citas del doctor

Route::get('/doctor/mis-citas', [CitaController::class, 'misCitasDoctor'])->name('doctor.citas');
Route::put('/doctor/cita/{id}/completar', [CitaController::class, 'completarCita'])->name('doctor.cita.completar');





// Rutas para Enfermería
Route::prefix('enfermeria')->name('enfermeria.')->group(function () {
    Route::get('/habitaciones', [AsignacionHabitacionController::class, 'index'])->name('habitaciones.index');
    Route::get('/habitaciones/asignar', [AsignacionHabitacionController::class, 'create'])->name('habitaciones.asignar');
    Route::post('/habitaciones', [AsignacionHabitacionController::class, 'store'])->name('habitaciones.store');
    Route::put('/habitaciones/{id}/liberar', [AsignacionHabitacionController::class, 'liberar'])->name('habitaciones.liberar');
});

// Rutas para Recepcionista
Route::prefix('recepcionista')->name('recepcionista.')->group(function () {
    Route::get('/habitaciones', [VisualizacionHabitacionController::class, 'index'])->name('habitaciones.index');
    Route::get('/habitaciones/buscar', [VisualizacionHabitacionController::class, 'buscar'])->name('habitaciones.buscar');
    Route::get('/habitaciones/ocupadas', [VisualizacionHabitacionController::class, 'listarOcupadas'])->name('habitaciones.ocupadas');
    Route::get('/habitaciones/asignar', [AsignacionHabitacionController::class, 'createRecepcionista'])->name('habitaciones.asignar');
    Route::post('/habitaciones/asignar', [AsignacionHabitacionController::class, 'storeRecepcionista'])->name('habitaciones.store');
    Route::put('/habitaciones/liberar/{id}', [AsignacionHabitacionController::class, 'liberarRecepcionista'])->name('recepcionista.habitaciones.liberar');
    Route::get('/expediente/{id}/enviar-doctor', [RecepcionistaController::class, 'vistaEnviarDoctor'])->name('vistaEnviarDoctor');
    Route::post('/expediente/enviar-doctor', [RecepcionistaController::class, 'enviarDoctor'])->name('enviarDoctor');
    Route::put('/habitaciones/liberar/{id}', [AsignacionHabitacionController::class, 'liberarRecepcionista'])->name('habitaciones.liberar');

});

// HABITACIONES - DOCTOR
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/habitaciones', [DoctorHabitacionController::class, 'index'])->name('habitaciones.index');
    Route::get('/habitaciones/buscar', [DoctorHabitacionController::class, 'buscar'])->name('habitaciones.buscar');
    Route::get('/habitaciones/mis-pacientes', [DoctorHabitacionController::class, 'misPacientes'])->name('habitaciones.mis-pacientes');
});

//Inventario de Medicamentos
Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.principal');
Route::get('/inventario/registrar', [InventarioController::class, 'create'])->name('inventario.create');
Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
Route::get('/inventario/{id}/editar', [InventarioController::class, 'edit'])->name('inventario.edit');
Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');


Route::get('/historialDiario', [RecepcionistaController::class, 'historialDiario'])->name('historial.diario');
Route::get('/listaDoctores', [RecepcionistaController::class, 'listaDoctores'])->name('lista.doctores');




Route::get('/promociones', [PromocionController::class, 'promociones'])->name('promociones');
Route::post('/promociones', [PromocionController::class, 'store'])->name('promociones.store');

Route::get('/promociones/imagen/{id}', [PromocionController::class, 'mostrarImagen'])->name('promociones.imagen');
// Rutas AJAX para información de doctores
Route::get('/doctor/{id}/info', [RutasController::class, 'getDoctorInfo'])->name('doctor.info');
Route::get('/doctores/especialidad/{especialidad}', [RutasController::class, 'getDoctoresPorEspecialidad'])->name('doctores.especialidad');
Route::get('/estadisticas', [RutasController::class, 'getEstadisticas'])->name('estadisticas');
Route::post('/verificar-puede-calificar', [RutasController::class, 'verificarPuedeCalificar'])->name('verificar.calificar');
