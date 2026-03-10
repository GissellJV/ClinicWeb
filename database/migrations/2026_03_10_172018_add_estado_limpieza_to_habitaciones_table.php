<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('habitaciones', function (Blueprint $table) {
            $table->enum('estado_limpieza', ['limpia', 'pendiente', 'en_limpieza'])
                ->default('pendiente')
                ->after('estado');

            $table->timestamp('fecha_limpieza')
                ->nullable()
                ->after('estado_limpieza');
        });
    }

    public function down(): void
    {
        Schema::table('habitaciones', function (Blueprint $table) {
            $table->dropColumn(['estado_limpieza', 'fecha_limpieza']);
        });
    }
};
