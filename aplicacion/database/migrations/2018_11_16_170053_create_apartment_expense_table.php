<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_expense', function (Blueprint $table) {
            $table->integer('apartment_id')->unsigned();
            $table->integer('expense_id')->unsigned();

            $table->foreign('apartment_id')->references('id')->on('apartments');
            $table->foreign('expense_id')->references('id')->on('expenses')->ondelete('cascade');
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
        Schema::dropIfExists('apartment_expense');
    }
}