<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->dateTime('fecha_hora_incidente');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->string('empleado_nombre');
            $table->enum('tipo_incidente', ['Caída', 'Medicación', 'Alergia', 'Equipo Médico', 'Otro']);
            $table->enum('gravedad', ['Leve', 'Moderado', 'Grave', 'Crítico']);
            $table->text('acciones_tomadas')->nullable();
            $table->enum('estado', ['Pendiente', 'En Revisión', 'Resuelto'])->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidentes');
    }
};
