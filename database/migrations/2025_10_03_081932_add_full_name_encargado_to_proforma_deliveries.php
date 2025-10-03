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
        $table->string('full_name_encargado')->nullable(); // Agrega la columna, si no es obligatoria agrega 'nullable'
    });
}

public function down()
{
    Schema::table('proforma_deliveries', function (Blueprint $table) {
        $table->dropColumn('full_name_encargado');
    });
}

};
