<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Implementar tabla para la historia H80 - Emanuel Tercero
     */
    public function up(): void
    {
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();
            // Relación con el paciente que solicita el traslado
            $table->unsignedBigInteger('paciente_id');

            // Campos requeridos por la historia H80
            $table->string('direccion_destino');
            $table->dateTime('fecha_traslado');
            $table->string('unidad_asignada'); // Almacena la ambulancia elegida
            $table->decimal('costo_estimado', 10, 2)->default(0.00);

            // Estado del traslado para control interno
            $table->enum('estado', ['Pendiente', 'En Curso', 'Finalizado', 'Cancelado'])->default('Pendiente');

            $table->timestamps();

            // Definir la clave foránea vinculada a tu modelo Paciente
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
