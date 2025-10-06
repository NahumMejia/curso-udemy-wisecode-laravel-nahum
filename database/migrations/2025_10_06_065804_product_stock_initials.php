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
        Schema::create('product_Stock_initials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('state')->default(1);
            $table->double('price_unit_avg')->default(0);
            $table->double('stock')->default(0);
            $table->string('description')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            
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
