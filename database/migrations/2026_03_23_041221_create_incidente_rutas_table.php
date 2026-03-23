<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidente_rutas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('traslado_id');
            $table->string('tipo_incidente');
            $table->integer('minutos_retraso')->default(0);
            $table->text('nota_descriptiva')->nullable();
            $table->enum('estado_incidente', ['Activo', 'Resuelto'])->default('Activo');
            $table->timestamps();

            $table->foreign('traslado_id')->references('id')->on('traslados')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidente_rutas');
    }
};
