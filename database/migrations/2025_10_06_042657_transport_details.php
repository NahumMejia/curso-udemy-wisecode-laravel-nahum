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
        Schema::create('transport_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date_entrega')->nullable();
            $table->timestamp('date_salida')->nullable();
            $table->softDeletes();
            $table->string('description')->nullable();
            $table->double('quantity')->nullable();
            $table->double('price_unit')->nullable();
            $table->double('total')->nullable();
            $table->bigInteger('transport_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('user_entrega')->nullable();
            $table->bigInteger('user_salida')->nullable();
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
