<?php

namespace App\Http\Controllers;

use App\Events\GameUpdated;
use App\Events\ScoreUpdated;
use App\Game;
use App\GameMovie;
use App\Service\Utility;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $games = Game::with(array('player1Game', 'player2Game', 'movie'))->latest()->limit(10)->get();
        $result = array('games' => $games);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
        if(Utility::validPlayer())
        {
            $result = array('game' => $game);
            return response()->json($result)->setStatusCode(200);
        }
        $result = array('game' => null);
        return response()->json($result)->setStatusCode(401);
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
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
        $data = $request->all();
        $game->fill($data);
        $game->save();
        broadcast(new ScoreUpdated($game));

        if (isset($data['game_movie_id'])) {

            $gameMovie = GameMovie::findOrFail($data['game_movie_id']);
            $gameMovie->fill($data);
            $gameMovie->save();

        }

        $result = array('game' => $game);
        return response()->json($result)->setStatusCode(204);


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
