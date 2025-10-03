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
        Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->softDeletes();
        $table->string('name');
        $table->string('surname');
        $table->string('full_name');
        $table->string('phone');
        $table->string('email');
        $table->string('type_document');
        $table->string('n_document');
        $table->string('ubigeo_region');
        $table->string('ubigeo_provincia');
        $table->string('ubigeo_distrito');
        $table->string('region');
        $table->string('provincia');
        $table->string('distrito');
        $table->string('address');
        $table->timestamp('birthdate')->nullable();
        $table->tinyInteger('state')->default(1);
        $table->tinyInteger('type')->default(1);
        $table->tinyInteger('is_parcial')->default(1);
        $table->bigInteger('sucursale_id')->nullable();
        $table->bigInteger('asesor_id')->nullable();
        $table->bigInteger('client_segment_id')->nullable();
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
