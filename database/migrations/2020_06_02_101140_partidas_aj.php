<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartidasAj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidasAj', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('jugador1_id');
            $table->foreign('jugador1_id')->references('id')->on('users');
            $table->unsignedBigInteger('jugador2_id');
            $table->foreign('jugador2_id')->references('id')->on('users');
            $table->string('j1')->default('b');
            $table->string('j2')->default('n');
            $table->string('turno')->default('b');
            $table->integer('Victoria')->default(null);
            $table->string('tablero')->default('[[Tn,Cn,An,Qn,Kn,An,Cn,Tn],[Pn,Pn,Pn,Pn,Pn,Pn,Pn,Pn],[-,-,-,-,-,-,-,-],[-,-,-,-,-,-,-,-],[-,-,-,-,-,-,-,-],[-,-,-,-,-,-,-,-],[Pb,Pb,Pb,Pb,Pb,Pb,Pb,Pb],[Tb,Cb,Ab,Qb,Kb,Ab,Cb,Tb]]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
