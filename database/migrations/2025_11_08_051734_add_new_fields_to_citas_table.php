<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Agregar campos necesarios para H3 y H8
            if (!Schema::hasColumn('citas', 'empleado_id')) {
                $table->foreignId('empleado_id')->nullable()->after('paciente_id')->constrained('empleados')->onDelete('cascade');
            }

            if (!Schema::hasColumn('citas', 'paciente_nombre')) {
                $table->string('paciente_nombre')->nullable()->after('paciente_id');
            }

            if (!Schema::hasColumn('citas', 'doctor_nombre')) {
                $table->string('doctor_nombre')->nullable()->after('empleado_id');
            }

            if (!Schema::hasColumn('citas', 'fecha')) {
                $table->date('fecha')->nullable()->after('especialidad');
            }

            if (!Schema::hasColumn('citas', 'hora')) {
                $table->string('hora')->nullable()->after('fecha');
            }

            if (!Schema::hasColumn('citas', 'motivo')) {
                $table->text('motivo')->nullable()->after('hora');
            }

            if (!Schema::hasColumn('citas', 'mensaje')) {
                $table->text('mensaje')->nullable()->after('motivo');
            }

            // Eliminar campos antiguos si existen
            if (Schema::hasColumn('citas', 'fecha_cita')) {
                $table->dropColumn('fecha_cita');
            }

            if (Schema::hasColumn('citas', 'notas')) {
                $table->dropColumn('notas');
            }

            if (Schema::hasColumn('citas', 'doctor_id')) {
                $table->dropForeign(['doctor_id']);
                $table->dropColumn('doctor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['empleado_id']);
            $table->dropColumn([
                'empleado_id',
                'paciente_nombre',
                'doctor_nombre',
                'fecha',
                'hora',
                'motivo',
                'mensaje'
            ]);
        });
    }
};
