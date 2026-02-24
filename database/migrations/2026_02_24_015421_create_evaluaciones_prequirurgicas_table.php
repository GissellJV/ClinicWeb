<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluaciones_prequirurgicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade'); // doctor

            // Datos clínicos
            $table->string('tipo_cirugia'); // Ej: Apendicectomía, Hernia, etc.
            $table->string('diagnostico');
            $table->text('descripcion_procedimiento');
            $table->enum('nivel_riesgo', ['bajo', 'medio', 'alto']);
            $table->text('observaciones')->nullable();

            // Signos vitales
            $table->string('presion_arterial')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 4, 2)->nullable();

            // Antecedentes
            $table->text('alergias')->nullable();
            $table->text('medicamentos_actuales')->nullable();
            $table->text('antecedentes_quirurgicos')->nullable();

            // Estado
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('aprobada');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_prequirurgicas');
    }
};
