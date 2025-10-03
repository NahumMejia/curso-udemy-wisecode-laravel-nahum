<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImpuestoToProformaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->double('impuesto')->nullable();  // Añade la columna 'impuesto'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->dropColumn('impuesto');  // Elimina la columna 'impuesto' si se revierte la migración
        });
    }
}
