<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('title');
            $table->unsignedBigInteger('checklist_items');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('card_id');
            $table->foreign('checklist_items')->references('id')->on('checklist_items');
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
        Schema::dropIfExists('checklists');
    }
}
