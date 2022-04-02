<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workgroups', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('title');
            $table->unsignedBigInteger('users');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('kanban_id');
            $table->foreign('users')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('kanban_id')->references('id')->on('kanban');
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
        Schema::dropIfExists('workgroups');
    }
}
