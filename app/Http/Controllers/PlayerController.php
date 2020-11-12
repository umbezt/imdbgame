<?php

namespace App\Http\Controllers;

use App\Player;
use App\Service\Utility;
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

            $result = array('player' => $hasAlreadySetName->first());
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
        $cookie = '';
        if(\request()->hasCookie('player'))
        {
            $cookie = \request()->cookie('player');
        }
        $player = (Utility::getPlayer($cookie))->first() ;

        $hasActiveGame = Utility::hasActiveGame($player);


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
