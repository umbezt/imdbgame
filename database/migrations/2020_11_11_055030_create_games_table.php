<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('state')->default(1);
            $table->integer('score1')->default(0);
            $table->integer('score2')->default(0);
            $table->unsignedBigInteger('player1')->nullable();
            $table->unsignedBigInteger('player2')->nullable();
            $table->unsignedBigInteger('winner')->nullable();
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
        Schema::dropIfExists('games');
    }
}
