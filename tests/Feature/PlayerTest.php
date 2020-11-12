<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class PlayerTest extends TestCase
{

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
        $player = $this->postJson('/api/v1/player', ['name' => 'Sally']);
        $response = $this->withCookie([
            'player' => $player['player']->hashed_name
        ])->getJson('/api/v1/player/start');
        $response
            ->assertStatus(201)
        ;
    }
}
