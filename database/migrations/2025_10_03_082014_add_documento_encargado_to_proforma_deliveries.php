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
        $table->string('documento_encargado')->nullable(); // Puedes ajustarlo si necesitas un tipo diferente
    });
}

public function down()
{
    Schema::table('proforma_deliveries', function (Blueprint $table) {
        $table->dropColumn('documento_encargado');
    });
}

};
