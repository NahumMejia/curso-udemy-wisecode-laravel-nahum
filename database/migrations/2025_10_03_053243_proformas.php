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
        Schema::create('proformas', function (Blueprint $table) { 
        $table->id();
        $table->timestamps();
        $table->softDeletes();
        $table->string('description')->nullable();
        $table->bigInteger('user_id');  
        $table->bigInteger('client_id');  
        $table->bigInteger('client_segment_id');  
        $table->double('subtotal');
        $table->double('discount');
        $table->double('total');
        $table->double('igv');
        $table->double('deuda')->default(0);
        $table->double('paid_out')->default(0);
        $table->timestamp('date_validation')->nullable();
        $table->timestamp('date_pay_complete')->nullable();
        $table->tinyInteger('state_proforma')->default(1);
        $table->tinyInteger('state_payment')->default(1);
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
