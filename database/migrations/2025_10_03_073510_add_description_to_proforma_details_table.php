<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToProformaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->string('description')->nullable();  // Añade la columna 'description'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proforma_details', function (Blueprint $table) {
            $table->dropColumn('description');  // Elimina la columna 'description' si se revierte la migración
        });
    }
}
