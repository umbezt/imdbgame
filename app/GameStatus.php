<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameStatus extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
    ];

    public function game()
    {
        return $this->hasMany(Game::class, 'state' );
    }
}
