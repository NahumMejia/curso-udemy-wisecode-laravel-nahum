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
        Schema::create('providers', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->softDeletes();
        $table->string('full_name');
        $table->string('imagen');
        $table->string('ruc');
        $table->string('email');
        $table->string('phone');
        $table->string('address');
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
