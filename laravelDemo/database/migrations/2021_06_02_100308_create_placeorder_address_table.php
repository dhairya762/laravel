<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceorderAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeorder_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('placeorder_id')->unsigned();
            $table->foreign('placeorder_id')->references('id')->on('placeorder')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('address_type', ['billing', 'shipping']);
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zipcode');
            $table->string('same_as_billing')->default('0');
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
        Schema::dropIfExists('placeorder_address');
    }
}
