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
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('title');
            $table->string('description');
            $table->integer('orderNo');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('labels');
            $table->unsignedBigInteger('comments');
            $table->unsignedBigInteger('attachement_id');
            $table->unsignedBigInteger('checklist_id');
            $table->foreign('board_id')->references('id')->on('boards');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('labels')->references('id')->on('labels');
            $table->foreign('comments')->references('id')->on('comments');
            $table->foreign('attachement_id')->references('id')->on('attachements');
            $table->foreign('checklist_id')->references('id')->on('checklists');
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
