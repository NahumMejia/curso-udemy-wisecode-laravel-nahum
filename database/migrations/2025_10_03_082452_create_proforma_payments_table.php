<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('proforma_payments', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('proforma_id')->unsigned();
        $table->bigInteger('method_payment_id')->unsigned();
        $table->bigInteger('banco_id')->unsigned()->nullable();
        $table->double('amount')->default(0);
        $table->timestamp('date_validation');
        $table->string('n_transaccion')->default('Unknow');
        $table->string('voucher')->default('Unknow');
        $table->timestamps();
        $table->softDeletes();
    });
}

public function down()
{
    Schema::dropIfExists('proforma_payments');
}

};
