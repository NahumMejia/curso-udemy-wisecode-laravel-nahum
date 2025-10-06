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
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('state')->default(1);
            $table->double('quantity_start')->default(0);
            $table->double('quantity_end')->default(0);
            $table->double('quantity')->default(0);
            $table->string('description')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('unit_start_id')->nullable();
            $table->bigInteger('unit_end_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            
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
