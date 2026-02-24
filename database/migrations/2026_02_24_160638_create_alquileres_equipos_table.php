<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Implementar la estructura para la H72 vinculada a la H73
     */
    public function up(): void
    {
        Schema::create('alquileres_equipos', function (Blueprint $table) {
            $table->id();

            // Relación con el paciente que realiza el alquiler
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->onDelete('cascade');

            // Relación con la tabla inventarios (H73)
            $table->foreignId('equipo_id')
                ->constrained('inventarios')
                ->onDelete('cascade');

            // Datos específicos del alquiler
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('costo_total', 10, 2)->default(0);

            // Estado del alquiler para control interno
            $table->string('estado')->default('Activo'); // Activo, Finalizado, Cancelado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres_equipos');
    }
};
