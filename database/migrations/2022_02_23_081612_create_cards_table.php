<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanbans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('order')->nullable();
            $table->timestamps();
        });
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('kanban_id');
            $table->foreign('kanban_id')->references('id')->on('kanbans');
            $table->timestamps();
        });
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('color');
            $table->timestamps();
        });
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('uid')->unique();
            $table->string('description')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->boolean('isActive');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('label_id')->nullable();;
            $table->foreign('board_id')->references('id')->on('boards');
            $table->foreign('label_id')->references('id')->on('labels');
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
        Schema::dropIfExists('cards');
    }
}
