<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cajas_sucursales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date_close');
            $table->softDeletes();
            $table->double('efectivo_initial')->default(0);
            $table->double('efectivo_finish')->default(0);
            $table->double('ingresos')->default(0);
            $table->double('egresos')->default(0);
            $table->double('efectivo_process')->default(0);
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('caja_id')->nullable();
            $table->bigInteger('user_close')->nullable();
            $table->tinyInteger('state')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
