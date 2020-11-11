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
            $this->integer('state')->default(1);
            $this->integer('score1')->default(0);
            $this->integer('score2')->default(0);
            $this->unsignedBigInteger('player1')->nullable();
            $this->unsignedBigInteger('player2')->nullable();
            $this->unsignedBigInteger('winner')->nullable();
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
