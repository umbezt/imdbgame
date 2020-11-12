<?php

use Illuminate\Database\Seeder;

class GameStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\GameStatus::create(['description' => "Waiting"]);
        \App\GameStatus::create(['description' => "Started"]);
        \App\GameStatus::create(['description' => "Finished"]);
    }
}
