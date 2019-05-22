<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro')->unsigned();
            $table->decimal('amount', 15, 2);
            $table->integer('apartment_id')->unsigned();
            $table->integer('status')->unsigned();
            $table->date('date');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
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
        Schema::dropIfExists('billing_notices');
    }
}
