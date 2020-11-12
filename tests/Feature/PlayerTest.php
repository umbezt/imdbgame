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
        $player = json_decode($response->getContent(), true)['player'];
        $response = $this->withCookie([
            'player' => $player->hashed_name
        ])->getJson('/api/v1/player/start');
        $response
            ->assertStatus(200)
        ;
    }
}
