<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('tower_id')->unsigned();
            $table->integer('floor')->unsigned();
            $table->string('apartment');
            $table->string('intercom')->nullable();
            $table->string('parking')->nullable();
            $table->float('aliquot');
            $table->foreign('tower_id')->references('id')->on('towers');
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
        Schema::dropIfExists('apartments');
    }
}
