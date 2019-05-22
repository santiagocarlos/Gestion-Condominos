<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro_confirmation');
            $table->decimal('amount', 15, 2);
            $table->string('image');
            $table->integer('bank_id')->unsigned();
            $table->integer('bank_condominia_id')->unsigned();
            $table->integer('way_to_pay_id')->unsigned();
            $table->date('date_pay');
            $table->date('date_confirm')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('bank_condominia_id')->references('id')->on('banks_condominia');
            $table->foreign('way_to_pay_id')->references('id')->on('ways_to_pays');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
