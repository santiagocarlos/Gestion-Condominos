<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingNoticePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_notice_payment', function (Blueprint $table) {
            $table->integer('payment_id')->unsigned();
            $table->integer('billing_notice_id')->unsigned();
            $table->decimal('amount', 15, 2);
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('billing_notice_id')->references('id')->on('billing_notices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_notice_payment');
    }
}
