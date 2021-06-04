<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceorderCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeorder_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('placeorder_id')->unsigned();
            $table->foreign('placeorder_id')->references('id')->on('placeorder')->onDelete('cascade')->onUpdate('cascade');
            $table->string('comment')->nullable();
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered'])->default('pending');
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
        Schema::dropIfExists('placeorder_comments');
    }
}
