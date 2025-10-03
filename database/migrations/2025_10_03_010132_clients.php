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
            $table->string('name')->default('Unknown');
            $table->string('surname')->default('Unknown');
            $table->string('full_name')->default('Unknown');
            $table->string('phone')->default('Unknown');
            $table->string('email')->default('Unknown');
            $table->string('type_document')->default('Unknown');
            $table->string('n_document')->default('Unknown');
            $table->string('ubigeo_region')->default('Unknown');
            $table->string('ubigeo_provincia')->default('Unknown');
            $table->string('ubigeo_distrito')->default('Unknown');
            $table->string('region')->default('Unknown');
            $table->string('provincia')->default('Unknown');
            $table->string('distrito')->default('Unknown');
            $table->string('address')->default('Unknown');
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
        Schema::dropIfExists('clients');
    }
};
