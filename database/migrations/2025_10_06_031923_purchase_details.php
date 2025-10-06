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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date_entrega')->nullable();
            $table->softDeletes();
            $table->string('description')->nullable();
            $table->double('quantity')->nullable();
            $table->double('price_unit')->nullable();
            $table->double('total')->nullable();
            $table->bigInteger('purchase_id');
            $table->bigInteger('product_id');
            $table->bigInteger('unit_id');
            $table->bigInteger('user_entrega')->nullable();
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
