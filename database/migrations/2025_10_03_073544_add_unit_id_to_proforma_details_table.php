<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdToProformaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->bigInteger('unit_id')->nullable();  // Añade la columna 'unit_id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->dropColumn('unit_id');  // Elimina la columna 'unit_id' si se revierte la migración
        });
    }
}
