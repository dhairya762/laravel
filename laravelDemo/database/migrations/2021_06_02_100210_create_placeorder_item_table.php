<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceorderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeorder_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('placeorder_id')->unsigned();
            $table->foreign('placeorder_id')->references('id')->on('placeorder')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->string('quantity')->default(1);
            $table->string('base_price');
            $table->string('price');
            $table->string('discount');
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
        Schema::dropIfExists('placeorder_item');
    }
}
