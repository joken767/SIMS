<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('stock_cost_id');
            $table->integer('stock_id');
            $table->string('ris_no');
            $table->date('date_issued');
            $table->integer('location_id');
            $table->integer('transaction_id');
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
        Schema::dropIfExists('issued');
    }
}
