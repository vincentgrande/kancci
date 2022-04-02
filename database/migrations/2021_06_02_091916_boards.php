<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Boards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('title');
            $table->integer('orderNo');
            $table->unsignedBigInteger('kanban_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('labels');
            $table->unsignedBigInteger('cards');
            $table->foreign('kanban_id')->references('id')->on('kanban');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('labels')->references('id')->on('labels');
            $table->foreign('cards')->references('id')->on('cards');
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
        Schema::dropIfExists('boards');
    }
}
