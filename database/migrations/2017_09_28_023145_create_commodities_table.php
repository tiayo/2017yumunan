<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //商品名称
            $table->float('price'); //商品价格
            $table->longText('description'); //商品描述
            $table->integer('type')->default(0); //商品分组（默认无分组0）
            $table->integer('status')->default(0); //商品状态（默认下架）
            $table->string('image_0')->nullable(); //商品图片1
            $table->string('image_1')->nullable(); //商品图片2
            $table->string('image_2')->nullable(); //商品图片3
            $table->string('image_3')->nullable(); //商品图片4
            $table->string('image_4')->nullable(); //商品图片5
            $table->string('image_5')->nullable(); //商品图片6
            $table->string('image_6')->nullable(); //商品图片7
            $table->string('image_7')->nullable(); //商品图片8
            $table->string('image_8')->nullable(); //商品图片9
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
        Schema::dropIfExists('commodities');
    }
}
