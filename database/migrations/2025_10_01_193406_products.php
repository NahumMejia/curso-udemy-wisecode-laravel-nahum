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
        Schema::create('products', function (Blueprint $table) { 
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('title');
            $table->string('imagen');
            $table->string('sku');
            $table->double('price_general');
            $table->string('description');
            $table->json('specifications');

            $table->bigInteger('product_categorie_id');
            $table->tinyInteger('is_gift')->default(1);
            $table->double('min_discount')->nullable();
            $table->double('max_discount')->nullable();
            $table->double('umbral');
            $table->bigInteger('umbral_unit_id')->nullable();
            $table->tinyInteger('disponibilidad')->default(1);
            $table->double('tiempo_de_abastecimiento')->nullable();
            $table->bigInteger('provider_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
