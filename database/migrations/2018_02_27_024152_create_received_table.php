<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('stock_cost_id');
            $table->date('date_received');
            $table->integer('transaction_id');
            $table->string('pr_no');
            $table->string('po_no');
            $table->integer('supplier_id');
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
        Schema::dropIfExists('received');
    }
}
