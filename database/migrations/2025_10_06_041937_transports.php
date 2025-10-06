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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('date_emision')->nullable();
            $table->timestamp('date_entrega')->nullable();
            $table->softDeletes()->nullable();
            $table->string('type_comprobant')->default(1); 
            $table->double('total')->nullable();
            $table->double('importe')->nullable();
            $table->double('igv')->nullable();
            $table->string('description')->nullable();; 
            $table->bigInteger('user_id')->nullable();            
            $table->bigInteger('warehouse_start_id')->nullable();            
            $table->bigInteger('warehouse_end_id')->nullable();           
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
