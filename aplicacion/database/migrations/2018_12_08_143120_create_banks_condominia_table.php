<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksCondominiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks_condominia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_number');
            $table->string('holder');
            $table->string('dni');
            $table->string('email');
            $table->integer('bank_id')->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
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
        Schema::dropIfExists('banks_condominia');
    }
}
