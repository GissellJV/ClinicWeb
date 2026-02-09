<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la tabla visitantes.
     * Acción: Implementar estructura técnica para registro de ingresos.
     */
    public function up(): void
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_visitante');
            $table->string('dni_visitante');
            $table->unsignedBigInteger('paciente_id');
            $table->dateTime('fecha_ingreso');

            // Auditoría técnica
            $table->timestamps();

            // Validar relación técnica con la tabla pacientes
            $table->foreign('paciente_id')
                ->references('id')
                ->on('pacientes')
                ->onDelete('cascade');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};
