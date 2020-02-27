<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToBeIssuedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_be_issued', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('stock_id');
            $table->string('ris_no');
            $table->date('date_issued');
            $table->integer('location_id');
            $table->integer('quantity_issued');
            $table->integer ('ref_no')->default (0);
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
        Schema::dropIfExists('to_be_issued');
    }
}
