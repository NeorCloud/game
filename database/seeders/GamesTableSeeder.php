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
                'title' => 'snake',
                'description' => NULL,
                'created_at' => '2022-05-03 16:31:43',
                'updated_at' => '2022-05-03 16:31:43',
            ),
        ));


    }
}
