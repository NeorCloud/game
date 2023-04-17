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

        \DB::table('games')->insert(array(
            0 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 1,
                    'title' => 'Snake',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            1 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 2,
                    'title' => 'Breakout',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            2 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 3,
                    'title' => 'Tetris',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            3 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 4,
                    'title' => 'Bomberman',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            4 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 5,
                    'title' => 'Frogger',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            5 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 6,
                    'title' => 'Missile Command',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            6 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 7,
                    'title' => 'Sokoban',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            7 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 8,
                    'title' => 'Jumper',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            8 =>
                array(
                    'created_at' => '2022-05-03 18:02:28',
                    'description' => NULL,
                    'id' => 9,
                    'title' => 'Puzzle Bobble',
                    'updated_at' => '2022-05-03 18:02:28',
                ),
            9 =>
                array(
                    'created_at' => '2023-04-17 19:14:16',
                    'description' => NULL,
                    'id' => 10,
                    'title' => 'Math',
                    'updated_at' => '2023-04-17 19:14:19',
                ),
            10 =>
                array(
                    'created_at' => '2023-04-17 19:14:16',
                    'description' => NULL,
                    'id' => 11,
                    'title' => 'Atom Game',
                    'updated_at' => '2023-04-17 19:14:16',
                ),
            11 =>
                array(
                    'created_at' => '2023-04-17 19:14:16',
                    'description' => NULL,
                    'id' => 12,
                    'title' => 'Space Ship',
                    'updated_at' => '2023-04-17 19:14:16',
                ),
            12 =>
                array(
                    'created_at' => '2023-04-17 19:14:16',
                    'description' => NULL,
                    'id' => 13,
                    'title' => 'Card Game',
                    'updated_at' => '2023-04-17 19:14:16',
                ),
        ));


    }
}
