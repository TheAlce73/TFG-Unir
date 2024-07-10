<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Amigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Amigos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jugador1_id');
            $table->foreign('jugador1_id')->references('id')->on('users');
            $table->unsignedBigInteger('jugador2_id');
            $table->foreign('jugador2_id')->references('id')->on('users');
            $table->boolean('son')->default(0);
        });
    }

    /**
     * Reverse the migrations. 
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Amigos');
    }
}
