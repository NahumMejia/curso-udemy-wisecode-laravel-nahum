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
        Schema::create('product_wallets', function (Blueprint $table) { 
        $table->id();
        $table->bigInteger('product_id');
        $table->bigInteger('unit_id');
        $table->bigInteger('client_segment_id');        
        $table->bigInteger('sucursale_id');        
        $table->double('price');        
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
