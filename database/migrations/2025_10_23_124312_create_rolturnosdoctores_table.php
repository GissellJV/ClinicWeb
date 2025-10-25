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
        Schema::create('rolturnosdoctores', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('hora_turno');
           $table->foreignId('empleado_id')->constrained();
           $table->foreignId('cita_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rolturnosdoctores');
    }
};
