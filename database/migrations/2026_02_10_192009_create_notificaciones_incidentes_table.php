<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones_incidentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidente_id')->constrained('incidentes')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade'); // Recepcionista
            $table->boolean('leido')->default(false);
            $table->timestamp('fecha_envio')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones_incidentes');
    }
};
