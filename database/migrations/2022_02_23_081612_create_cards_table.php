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
            $table->string('order')->nullable();
            $table->timestamps();
        });
        Schema::create('tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('kanban_id');
            $table->foreign('kanban_id')->references('id')->on('kanbans');
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
            $table->unsignedBigInteger('table_id');
            $table->foreign('table_id')->references('id')->on('tables');
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
