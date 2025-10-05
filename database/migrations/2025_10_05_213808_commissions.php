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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('week')->nullable();
            $table->string('position')->nullable();
            $table->double('amount')->nullable();
            $table->double('percentage')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('product_categorie_id')->nullable();
            $table->bigInteger('client_segment_id')->nullable();
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
