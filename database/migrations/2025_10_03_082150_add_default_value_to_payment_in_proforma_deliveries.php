<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('proforma_deliveries', function (Blueprint $table) {
        $table->double('payment')->default(0)->change(); // Establecer valor por defecto en 0
    });
}

public function down()
{
    Schema::table('proforma_deliveries', function (Blueprint $table) {
        $table->double('payment')->default(NULL)->change(); // Restablecer el valor por defecto a NULL si es necesario
    });
}

};
