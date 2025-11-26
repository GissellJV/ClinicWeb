<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('doctor_id')
                ->constrained('empleados')
                ->onDelete('cascade');

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->onDelete('cascade');

            // Datos de la calificación
            $table->integer('estrellas')->default(0);
            $table->text('comentario')->nullable();

            // Timestamps
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index('doctor_id');
            $table->index('paciente_id');

            // Evitar calificaciones duplicadas (un paciente solo puede calificar una vez a un doctor)
            $table->unique(['doctor_id', 'paciente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
