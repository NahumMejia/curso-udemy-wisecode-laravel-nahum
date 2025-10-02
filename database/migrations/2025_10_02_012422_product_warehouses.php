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
        Schema::create('product_warehouses', function (Blueprint $table) { 
        $table->id();
        $table->bigInteger('product_id');
        $table->bigInteger('unit_id');
        $table->bigInteger('warehouse_id');
        $table->double('stock');
        $table->integer('state_stock')->default(0);  
        $table->timestamps();
        $table->softDeletes();
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
