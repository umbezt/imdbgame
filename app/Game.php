<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player1', 'player2', 'score1', 'score2' , 'state', 'current_question' , 'winner'
    ];

    public function player1Game()
    {
        return $this->belongsTo(Player::class , 'player1' );
    }
    public function player2Game()
    {
        return $this->belongsTo(Player::class , 'player2' );
    }
    public function state()
    {
        return $this->belongsTo(GameStatus::class, 'state' );
    }
    public function movie()
    {
        return $this
            ->belongsToMany(Movie::class, 'game_movies', 'game_id', 'movie_id' )
            ->withPivot([ 'id',
                'answer1',
                'answer2'
                ]);
    }
}
