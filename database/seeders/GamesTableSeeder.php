<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('games')->delete();
        \DB::table('games')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Snake',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Breakout',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Tetris',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'Bomberman',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            4 =>
            array (
                'id' => 5,
                'title' => 'Frogger',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            5 =>
            array (
                'id' => 6,
                'title' => 'Missile Command',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            6 =>
            array (
                'id' => 7,
                'title' => 'Sokoban',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            7 =>
            array (
                'id' => 8,
                'title' => 'Jumper',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
            8 =>
            array (
                'id' => 9,
                'title' => 'Puzzle Bobble',
                'description' => NULL,
                'created_at' => '2022-05-03 18:02:28',
                'updated_at' => '2022-05-03 18:02:28',
            ),
        ));
    }
}
