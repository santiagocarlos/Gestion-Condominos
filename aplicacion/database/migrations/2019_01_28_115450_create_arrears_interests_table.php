<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrearsInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrears_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_notice_id')->unsigned();
            $table->decimal('surcharge', 15, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->foreign('billing_notice_id')->references('id')->on('billing_notices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrears_interests');
    }
}
