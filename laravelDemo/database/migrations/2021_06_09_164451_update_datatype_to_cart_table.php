<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatatypeToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->bigInteger('shipping_method_id')->unsigned()->nullable()->default(null)->change();
            $table->bigInteger('payment_method_id')->unsigned()->nullable()->default(null)->change();
            $table->bigInteger('customer_id')->unsigned()->nullable()->change();
            $table->string('shipping_amount')->nullable()->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            //
        });
    }
}
