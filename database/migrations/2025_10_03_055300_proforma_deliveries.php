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
        Schema::create('proforma_deliveries', function (Blueprint $table) { 
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->double('payment');
            $table->timestamp('date_entrega')->nullable();
            $table->timestamp('date_envio')->nullable();
            $table->string('address')->nullable();
            $table->string('ubi_region')->nullable();
            $table->string('ubi_providencia')->nullable();
            $table->string('ubi_distrito')->nullable();
            $table->string('region')->nullable();
            $table->string('providencia')->nullable();
            $table->string('distrito')->nullable();
            $table->bigInteger('proforma_id')->nullable();
            $table->bigInteger('sucursale_deliverie_id')->nullable();
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
