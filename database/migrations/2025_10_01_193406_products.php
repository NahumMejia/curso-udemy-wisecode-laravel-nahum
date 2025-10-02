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
            $table->json('specifications')->nullable();
            $table->bigInteger('product_categorie_id');
            $table->tinyInteger('is_gift')->default(1);
            $table->double('min_discount')->nullable();
            $table->double('max_discount')->nullable();
            $table->double('umbral');
            $table->tinyInteger('is_discount')->default(1);
            $table->string('tax_selected');
            $table->decimal('importe_iva', 8, 2)->default(0);
            $table->bigInteger('umbral_unit_id')->nullable();
            $table->tinyInteger('disponiblidad')->default(1);
            $table->tinyInteger('state')->default(1);
            $table->integer('tiempo_de_abastecimiento')->default(0);
            $table->bigInteger('provider_id')->nullable();
            $table->decimal('weight', 8, 2)->default(0);
            $table->decimal('width', 8, 2)->default(0);
            $table->decimal('height', 8, 2)->default(0);
            $table->decimal('length', 8, 2)->default(0);
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
