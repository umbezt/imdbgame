<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GameMovie extends Pivot
{

    protected $table = 'game_movies';
    public $incrementing = true;

    protected $fillable = [
        'answer1', 'answer2'
    ];
}
