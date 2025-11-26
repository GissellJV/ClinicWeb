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
        Schema::create('aplicacion_medicamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('inventario_id');
            $table->unsignedBigInteger('habitacion_id')->nullable();
            $table->integer('cantidad')->default(1);
            $table->dateTime('fecha_aplicacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('inventario_id')->references('id')->on('inventario_medicamentos')->onDelete('cascade');
            $table->foreign('habitacion_id')->references('id')->on('habitaciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplicacion_medicamento');
    }
};
