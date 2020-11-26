<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'yearOfRelease', 'imageUrl',
    ];

    public function game()
    {
        return $this->belongsToMany(Game::class, 'game_movies' );
    }
}
