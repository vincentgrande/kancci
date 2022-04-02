<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Labels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('label');
            $table->string('color');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('card_id');
            $table->foreign('board_id')->references('id')->on('boards');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('card_id')->references('id')->on('cards');
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
        Schema::dropIfExists('labels');
    }
}
