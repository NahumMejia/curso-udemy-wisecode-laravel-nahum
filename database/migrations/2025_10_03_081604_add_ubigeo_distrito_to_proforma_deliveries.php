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
        $table->string('ubigeo_distrito')->nullable(); // Agrega la columna como nullable si no es obligatorio
    });
}

public function down()
{
    Schema::table('proforma_deliveries', function (Blueprint $table) {
        $table->dropColumn('ubigeo_distrito'); // Elimina la columna en caso de revertir la migración
    });
}

};
