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
    Schema::table('proformas', function (Blueprint $table) {
        $table->date('date_entrega')->nullable(); // Agrega la columna 'date_entrega'
    });
}

public function down()
{
    Schema::table('proformas', function (Blueprint $table) {
        $table->dropColumn('date_entrega'); // Elimina la columna si la migración es revertida
    });
}

};
