<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create ('stocks', function (Blueprint $table) {
            $table->increments ('id');
            $table->integer ('user_id');
            $table->string ('stock_type');
            $table->string ('stock_code');
            $table->string ('item_no');
            $table->string ('desc');
            $table->integer ('total_stocks_available')->default(0);
            $table->string ('unit');
            $table->date ('exp_date')->nullable ();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('stocks');
    }
}
