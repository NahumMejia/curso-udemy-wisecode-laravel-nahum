<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUbigeoProvinciaToProformaDeliveries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proforma_deliveries', function (Blueprint $table) {
            $table->string('ubigeo_provincia')->nullable();  // Agrega la columna 'ubigeo_provincia' como string y permite valores nulos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proforma_deliveries', function (Blueprint $table) {
            $table->dropColumn('ubigeo_provincia');  // Elimina la columna si se revierte la migración
        });
    }
}
