<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            //$table->string('especialidad')->nullable();
           // $table->date('fecha')->nullable();
            //$table->string('hora')->nullable();
           // $table->string('estado')->default('pendiente');
            $table->string('mensaje')->nullable();
            $table->string('doctor_nombre')->nullable();
            $table->string('paciente_nombre')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn(['especialidad','fecha','hora','estado', 'mensaje', 'doctor_nombre', 'paciente_nombre']);
        });
    }
};
