<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_product_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salesman_id');
            $table->foreign('salesman_id')->references('id')->on('salesman')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('salesman_product_id');
            $table->foreign('salesman_product_id')->references('id')->on('salesman_product')->onDelete('cascade')->onUpdate('cascade');
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
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
        Schema::dropIfExists('salesman_product_price');
    }
}
