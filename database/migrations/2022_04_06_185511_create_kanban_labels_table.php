<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanbanLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanban_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kanban_id');
            $table->foreign('kanban_id')->references('id')->on('kanbans');
            $table->unsignedBigInteger('label_id');
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
        Schema::dropIfExists('kanban_labels');
    }
}
