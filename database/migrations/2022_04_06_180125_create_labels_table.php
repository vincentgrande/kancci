<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('color');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
        $labels =  array(
            [
                'label' => 'Blue',
                'color' => '#0800ff'
            ],
            [
                'label' => 'Red',
                'color' => '#ff0000'
            ],
            [
                'label' => 'Green',
                'color' => '#2bff00'
            ],
        );
        foreach ($labels as $label){
            \App\Label::create([
                'label' => $label['label'],
                'color' => $label['color']
            ]);
        }
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
