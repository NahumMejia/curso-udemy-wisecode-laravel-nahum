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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date_emision')->nullable();
            $table->timestamp('date_entrega')->nullable();
            $table->softDeletes();
            $table->string('type_comprobant'); 
            $table->double('total');
            $table->double('importe');
            $table->double('igv');
            $table->string('n_comprobant')->nullable();; 
            $table->string('description')->nullable();; 
            $table->bigInteger('warehouse_id')->nullable();;
            $table->bigInteger('user_id')->nullable();;
            $table->bigInteger('provider_id')->nullable();;
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
