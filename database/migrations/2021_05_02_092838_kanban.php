<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kanban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanban', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('title');
            $table->string('visibility');
            $table->unsignedBigInteger('workgroup_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('labels');
            $table->unsignedBigInteger('boards');
            $table->foreign('workgroup_id')->references('id')->on('workgroup');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('labels')->references('id')->on('labels');
            $table->foreign('boards')->references('id')->on('boards');
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
        Schema::dropIfExists('kanban');
    }
}
