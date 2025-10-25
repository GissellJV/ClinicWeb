<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Agregar las columnas si no existen
            if (!Schema::hasColumn('citas', 'paciente_id')) {
                $table->unsignedBigInteger('paciente_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('citas', 'empleado_id')) {
                $table->unsignedBigInteger('empleado_id')->nullable()->after('paciente_id');
            }

            if (!Schema::hasColumn('citas', 'rolturnosdoctores_id')) {
                $table->unsignedBigInteger('rolturnosdoctores_id')->nullable()->after('empleado_id');
            }

            // Luego agregar las claves foráneas
            $table->foreign('paciente_id')
                ->references('id')
                ->on('pacientes')
                ->onDelete('cascade');

            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleados')
                ->onDelete('cascade');

            $table->foreign('rolturnosdoctores_id')
                ->references('id')
                ->on('rolturnosdoctores')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['paciente_id']);
            $table->dropForeign(['empleado_id']);
            $table->dropForeign(['rolturnosdoctores_id']);
            $table->dropColumn(['paciente_id', 'empleado_id', 'rolturnosdoctores_id']);
        });
    }
};



/**
     * Reverse the migrations.
     */

