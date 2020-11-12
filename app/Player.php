<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'hashed_name',
    ];

    public function player1Game()
    {
        return $this->hasMany(Game::class, 'player1' );
    }
    public function player2Game()
    {
        return $this->hasMany(Game::class, 'player2' );
    }
}
