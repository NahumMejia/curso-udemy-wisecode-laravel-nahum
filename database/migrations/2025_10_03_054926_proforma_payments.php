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
        Schema::create('proforma_payments', function (Blueprint $table) { 
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->double('payment');
            $table->double('amount');
            $table->timestamp('date_validation')->nullable();
            $table->string('n_transaccion')->nullable();
            $table->bigInteger('proforma_id')->nullable();
            $table->bigInteger('method_payment_id')->nullable();
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
