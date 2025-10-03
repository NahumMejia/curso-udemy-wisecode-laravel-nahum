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
        Schema::table('proformas', function (Blueprint $table) {
            // Agregar la columna sucursale_id
            $table->bigInteger('sucursale_id')->nullable()->after('client_segment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            // Eliminar la columna sucursale_id si se revierte la migración
            $table->dropColumn('sucursale_id');
        });
    }
};
