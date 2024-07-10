<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Partidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Partidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('jugador1_id');
            $table->foreign('jugador1_id')->references('id')->on('users');
            $table->unsignedBigInteger('jugador2_id');
            $table->foreign('jugador2_id')->references('id')->on('users');
            $table->string('j1')->default('X');
            $table->string('j2')->default('O');
            $table->string('turno')->default('X');
            $table->integer('Victoria')->default(null);
            $table->string('tablero')->default('[[-,-,-],[-,-,-],[-,-,-]]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Partidas');
    }
}
