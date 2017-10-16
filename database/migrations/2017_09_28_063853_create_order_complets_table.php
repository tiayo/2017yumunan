<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCompletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_complets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('commodity_id');
            $table->string('room');
            $table->integer('num'); //房间数
            $table->integer('day'); //入住天数
            $table->float('price');
            $table->integer('status')->default(0); //订单状态
            $table->string('remark'); //备注
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
        Schema::dropIfExists('order_complets');
    }
}
