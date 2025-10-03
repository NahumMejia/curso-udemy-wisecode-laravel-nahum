<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUbigeoRegionToProformaDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proforma_deliveries', function (Blueprint $table) {
            $table->string('ubigeo_region')->nullable();  // Añadir la columna 'ubigeo_region'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proforma_deliveries', function (Blueprint $table) {
            $table->dropColumn('ubigeo_region');  // Eliminar la columna 'ubigeo_region' si se revierte la migración
        });
    }
}