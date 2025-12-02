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
        Schema::create('historial_expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediente_id')->constrained('expedientes')->onDelete('cascade');
            $table->date('fecha');
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->string('temperatura')->nullable();
            $table->string('presion_arterial')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->text('alergias')->nullable();
            $table->text('medicamentos_actuales')->nullable();
            $table->text('antecedentes_familiares')->nullable();
            $table->text('antecedentes_personales')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_expedientes');
    }
};
