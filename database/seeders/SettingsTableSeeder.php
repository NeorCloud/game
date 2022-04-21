<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->delete();
        \DB::table('settings')->insert([
            0 =>
            [
                'id' => 1,
                'title' => 'لوگو داخلی',
                'description' => 'این لوگو در صفحات داخلی قرار می گیرد. آدرس کامل لوگو را در مقدار قرار دهید.',
                'value' => '14',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:39:01',
            ],
            1 =>
            [
                'id' => 2,
                'title' => 'لوگو خارجی این لوگو در صفحه لاگین قرار می گیرد.',
                'description' => 'این لوگو در صفحه لاگین قرار می گیرد. شناسه فایل آپلود شده در سیستم را در مقدار قرار دهید.',
                'value' => '3',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:38:51',
            ],
        ]);
    }
}
