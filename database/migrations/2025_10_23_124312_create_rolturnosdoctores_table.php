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
            $table->string('codigo_turno', 20);
            $table->string('nota', 255)->nullable();
            $table->foreignId('empleado_id')
                ->constrained('empleados')
                ->cascadeOnDelete();
            $table->unique(['fecha', 'empleado_id']);
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
