<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->constrained('evaluaciones_prequirurgicas')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade'); // cirujano

            // Datos de programación
            $table->string('tipo_cirugia');
            $table->string('quirofano'); // Ej: Quirófano 1, Quirófano 2
            $table->date('fecha_cirugia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('duracion_estimada_min'); // en minutos

            // Equipo
            $table->string('anestesiologo')->nullable();
            $table->text('instrumentos_requeridos')->nullable();
            $table->text('notas_adicionales')->nullable();

            // Estado
            $table->enum('estado', ['programada', 'en_proceso', 'completada', 'cancelada'])->default('programada');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cirugias');
    }
};
