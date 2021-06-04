<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeorder', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('total')->default(0);
            $table->string('discount')->default(0);
            $table->bigInteger('payment_method_id')->unsigned()->default(1);
            $table->foreign('payment_method_id')->references('id')->on('payment')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('shipping_method_id')->unsigned()->default(1);
            $table->foreign('shipping_method_id')->references('id')->on('shipping')->onDelete('cascade')->onUpdate('cascade');
            $table->string('shipping_amount')->default(0);
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
        Schema::dropIfExists('placeorder');
    }
}
