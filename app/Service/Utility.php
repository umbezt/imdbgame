<?php


namespace App\Service;

//this is a static class
use App\Game;
use App\Player;
use phpDocumentor\Reflection\Types\Mixed_;

class Utility
{

    public static function hashName(string $name, string $ip = ''): string
    {

        return sha1(date("Ymd") . $name . $ip);
    }

    public static function hasActiveGame($player) : bool
    {
        $games = Game::where('state', '!=', 3)
            ->where(function ($query) use ($player) {
                $query->orwhere('player1', $player->id)
                    ->orwhere('player2', $player->id);
            })->get();

        if ($games->count() > 0) {
            return true;
        }

        return false;
    }
    public static function getActiveGame( $player)
    {
        $game = Game::with(array('movie', 'player1Game', 'player2Game'))->where('state', '!=', 3)
            ->where(function($query) use ($player) {
                $query->orwhere('player1', $player->id)
                    ->orwhere('player2',  $player->id);
            })->first();

        if($game->count() > 0)
        {
            return $game;
        }

        return null;
    }

    public static function joinGame($player)
    {
        $gamesCheck = Game::where('state', '=', 1)
            ->whereNull('player2')
            ->get();
        $game = null;
        if ($gamesCheck->count() > 0  ) {  // are you player 2 or 1
            $game = $gamesCheck->first();
            $game->player2 = $player->id;
            $game->state = 2;
            $game->save();

        } else {
            $game = new Game();
            $game->player1 = $player->id;
            $game->save();

            $movies = \App\Movie::inRandomOrder()
                ->limit(8)->get();
            foreach ($movies as $movie) {
                $game->movie()->attach($movie->id);
            }

        }

        return Game::with(array('movie', 'player1Game', 'player2Game'))->find($game->id);




    }

    public static function getPlayer($cookie = null)
    {

        if(\request()->hasCookie('player'))
        {
            $cookie = \request()->cookie('player');
        }
        if(\request()->hasHeader('X-Cookie')){
            $cookie = \request()->header('X-Cookie');
        }
        return Player::where('hashed_name', $cookie)->get();
    }
    public static function validPlayer(): bool
    {
        $cookie = '';
        if(\request()->hasCookie('player'))
        {
            $cookie = \request()->cookie('player');
        }
        if(\request()->hasHeader('X-Cookie')){
            $cookie = \request()->header('X-Cookie');
        }
        $player = Player::where('hashed_name', $cookie)->get();
        if($player->count() > 0){
            return true;
        }
        return  false;
    }

}
