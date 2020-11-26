<?php

namespace App\Http\Controllers;

use App\Events\GameUpdated;
use App\Player;
use App\Service\Utility;
use \Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cookie = '';
        if(\request()->hasCookie('player'))
        {
            $cookie = \request()->cookie('player');
        }
        if(\request()->hasHeader('X-Cookie')){
            $cookie = \request()->header('X-Cookie');
        }
        $player = (Utility::getPlayer($cookie))->first() ;
        $result = array('player' => $player);
        return response()->json($result)->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|min:1|max:280|string']);


        $data['hashed_name'] = Utility::hashName($data['name'], $request->ip());
        $hasAlreadySetName = Utility::getPlayer($data['hashed_name']);
        if ($hasAlreadySetName->count() > 0) {
            $player = $hasAlreadySetName->last();
            $result = array('player' =>$player);

            return response()->json($result)->setStatusCode(201);
        }
        $player = Player::create($data);


        $result = array('player' => $player);
        return response()->json($result)->setStatusCode(201);
    }



    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function startGame()
    {

        //

        $player = (Utility::getPlayer())->last() ;

        $hasActiveGame = Utility::hasActiveGame($player);
        if($hasActiveGame){

            $game = Utility::getActiveGame($player);
            $result = array('game' => $game);
            return response()->json($result)->setStatusCode(200);
        }

        $game = Utility::joinGame($player);
        broadcast(new GameUpdated($game));
        $result = array('game' => $game);
        return response()->json($result)->setStatusCode(200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
