<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_tower', function (Blueprint $table) {
            $table->integer('tower_id')->unsigned();
            $table->integer('expense_id')->unsigned();

            $table->foreign('tower_id')->references('id')->on('towers');
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
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
        Schema::dropIfExists('service_tower');
    }
}
