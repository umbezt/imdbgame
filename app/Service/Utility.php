<?php


namespace App\Service;

//this is a static class
use App\Player;

class Utility
{

    public static function hashName( string $name, string $ip = '') : string
    {

        return sha1( date("Ymd"). $name . $ip );
    }

    public static function getPlayer(string $hashed_name)
    {
        return Player::where('hashed_name' , $hashed_name)->get();
    }

}
