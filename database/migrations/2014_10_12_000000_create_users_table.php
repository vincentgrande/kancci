<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->autoIncrement();
            $table->string('name');
            $table->string('email', '255')->unique('pm_email');
            $table->string('password');
            $table->string('reset_token');
            $table->unsignedBigInteger('boards')->nullable();
            $table->unsignedBigInteger('workgroups')->nullable();
            $table->foreign('boards')->references('id')->on('boards');
            $table->foreign('workgroups')->references('id')->on('workgroups');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
