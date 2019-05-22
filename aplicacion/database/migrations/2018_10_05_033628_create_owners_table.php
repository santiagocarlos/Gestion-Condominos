<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('apartment_id')->unsigned()->nullable();
            $table->boolean('status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('tower_id')->references('id')->on('towers');

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
        Schema::dropIfExists('owners');
        $table->dropForeign(['tower_id']);
    }
}
