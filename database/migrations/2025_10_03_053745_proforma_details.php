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
        Schema::create('proforma_details', function (Blueprint $table) { 
            $table->id();
            $table->timestamps();
            $table->softDeletes(); 
            $table->double('quantity');
            $table->double('price_unit');
            $table->double('discount')->default(0);
            $table->double('subtotal');
            $table->double('total');
            $table->bigInteger('proforma_id');   
            $table->bigInteger('product_id');   
            $table->bigInteger('product_categorie_id');   
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
