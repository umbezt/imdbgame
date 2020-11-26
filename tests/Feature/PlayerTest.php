<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

use Tests\TestCase;

class PlayerTest extends TestCase
{
//use DatabaseMigrations, RefreshDatabase;
    /**
     *
     * @return void
     */
    public function testCanSetName()
    {
        $response = $this->postJson('/api/v1/player', ['name' => 'Sally']);
        $response
            ->assertStatus(201)
        ;
    }

    /**
     *
     * @return void
     */
    public function testCanStartGame()
    {
        $response = $this->postJson('/api/v1/player', ['name' => 'Sally']);
        $response
            ->assertStatus(201)
        ;
        $responsePlayer = json_decode($response->getContent(), true);
        $player = $responsePlayer['player'];


        $response = $this->withHeader('X-Cookie', $player['hashed_name'])
            ->withCookie(
            'player',  $player['hashed_name']
        )->getJson('/api/v1/player/start');
        $response
            ->assertStatus(200)
        ;
    }
    /**
     *
     * @return void
     */
    public function testCanJoinGame()
    {

        //Player 1 start game
        $response = $this->postJson('/api/v1/player', ['name' => 'Sally']);
        $response
            ->assertStatus(201)
        ;
        $responsePlayer = json_decode($response->getContent(), true);
        $player = $responsePlayer['player'];


        $response = $this->withHeader('X-Cookie', $player['hashed_name'])
            ->withCookie(
            'player',  $player['hashed_name']
        )->getJson('/api/v1/player/start');
        $response
            ->assertStatus(200)
        ;


        //Player 2 join game
        $response2 = $this->postJson('/api/v1/player', ['name' => 'Jane']);
        $response2
            ->assertStatus(201)
        ;
        $responsePlayer2 = json_decode($response2->getContent(), true);
        $player2 = $responsePlayer2['player'];


        $response2 = $this->withHeader('X-Cookie', $player2['hashed_name'])
            ->withCookie(
                'player',  $player2['hashed_name']
            )->getJson('/api/v1/player/start');
        $response2
            ->assertStatus(200)
        ;
    }/**
     *
     * @return void
     */
    public function testCanPlayGame()
    {

        //Player 1 start game
        $response = $this->postJson('/api/v1/player', ['name' => 'Sally']);
        $response
            ->assertStatus(201)
        ;
        $responsePlayer = json_decode($response->getContent(), true);
        $player = $responsePlayer['player'];


        $response = $this->withHeader('X-Cookie', $player['hashed_name'])
            ->withCookie(
            'player',  $player['hashed_name']
        )->getJson('/api/v1/player/start');
        $response
            ->assertStatus(200)
        ;


        //Player 2 join game
        $response2 = $this->postJson('/api/v1/player', ['name' => 'Jane']);
        $response2
            ->assertStatus(201)
        ;
        $responsePlayer2 = json_decode($response2->getContent(), true);
        $player2 = $responsePlayer2['player'];


        $response2 = $this->withHeader('X-Cookie', $player2['hashed_name'])
            ->withCookie(
                'player',  $player2['hashed_name']
            )->getJson('/api/v1/player/start');
        $response2
            ->assertStatus(200)
        ;
        $game =  json_decode($response->getContent());
        //Play game

          $updateGameURL = '/api/v1/game/'. $game->game->id;


        $movies = $game->game->movie;
        $score1 = $score2 = 0;

        foreach ($movies as $movie){
            $player1Guess = rand(1990, 2015);
            $player2Guess = rand(1990, 2015);
            if($player1Guess == $movie->yearOfRelease){
                $score1+=5;
            } else {
                $score1-=3;
            }
            if($player2Guess == $movie->yearOfRelease){
                $score2+=5;
            } else {
                $score2-=3;
            }
            $currentGameState = $this->putJson($updateGameURL, ['score1' => $score1, 'game_movie_id'  => $movie->pivot->id, 'answer1' => $player1Guess ]);

            $currentGameState->assertStatus(204);
            $currentGameState2 = $this->putJson($updateGameURL, ['score2' => $score2, 'game_movie_id'  => $movie->pivot->id, 'answer2' => $player2Guess ]);

            $currentGameState2->assertStatus(204);
        }

      //End game

        $endGameResponse = $this->withHeader('X-Cookie', $player2['hashed_name'])
            ->withCookie(
                'player',  $player2['hashed_name']
            )->getJson($updateGameURL);
        $endGameState = $endGameResponse->getContent();
        $endGameResponse->assertStatus(200);
        $currentGameObject= json_decode($endGameState);



        $endGame['state'] = 3;
        if($currentGameObject->game->score1 != $currentGameObject->game->score2){
            if($currentGameObject->game->score1 >  $currentGameObject->game->score2) {
                $endGame['winner'] = $currentGameObject->game->player1 ;
            } else {
                $endGame['winner'] = $currentGameObject->game->player2 ;
            }
        }

        $endGameState = $this->putJson($updateGameURL, $endGame);
        $endGameState->assertStatus(204);


    }
}
