<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones_traslados', function (Blueprint $table) {
            $table->id();
            // Relación con el traslado realizado
            $table->foreignId('traslado_id')->constrained('traslados')->onDelete('cascade');
            // Puntuación de 1 a 5 estrellas
            $table->integer('puntuacion');
            // Comentario opcional limitado a 255 caracteres
            $table->string('comentario', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones_traslados');
    }
};
