<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVaucherToProformaPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proforma_payments', function (Blueprint $table) {
            $table->string('vaucher')->nullable();  // Agrega la columna 'vaucher' como string y permite valores nulos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proforma_payments', function (Blueprint $table) {
            $table->dropColumn('vaucher');  // Elimina la columna si se revierte la migración
        });
    }
}
