<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToBeReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_be_received', function (Blueprint $table) {
            $table->increments ('id');
            $table->integer ('user_id');
            $table->integer ('stock_id');
            $table->string ('pr_no');
            $table->string ('po_no');
            $table->date ('date_received');
            $table->integer ('supplier_id');
            $table->integer ('quantity_received');
            $table->integer ('cost');
            $table->timestamps ();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('to_be_received');
    }
}
