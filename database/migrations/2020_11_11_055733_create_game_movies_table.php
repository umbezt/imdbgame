<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_movies', function (Blueprint $table) {
            $table->id();
            $this->unsignedBigInteger('game_id')->index();
            $this->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $this->unsignedBigInteger('movie_id')->index();
            $this->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $this->integer('answer1')->nullable();
            $this->integer('answer2')->nullable();
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
        Schema::dropIfExists('game_movies');
    }
}
