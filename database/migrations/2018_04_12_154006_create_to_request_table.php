<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer ('location_id');
            $table->integer ('stock_id');
            $table->integer ('amount_requested');
            $table->string ('month_requested');
            $table->integer ('quarter_requested');
            $table->integer ('year_requested');
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
        Schema::dropIfExists('to_request');
    }
}
