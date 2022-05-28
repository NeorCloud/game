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
                'value' => '1',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:39:01',
            ],
            1 =>
            [
                'id' => 2,
                'title' => 'لوگو خارجی این لوگو در صفحه لاگین قرار می گیرد.',
                'description' => 'این لوگو در صفحه لاگین قرار می گیرد. شناسه فایل آپلود شده در سیستم را در مقدار قرار دهید.',
                'value' => '2',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:38:51',
            ],
            2 =>
            [
                'id' => 3,
                'title' => 'عکس تبلیغات بالا',
                'description' => 'این عکس تبلیعات در صفحه نمایش بازی قرار می گیرد. آدرس فایل را در مقدار قرار دهید.',
                'value' => '3',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:38:51',
            ],
            3 =>
            [
                'id' => 4,
                'title' => 'لینک تبلیغات بالا',
                'description' => 'این لینک عکس تبلیعات در صفحه نمایش بازی می باشد. لینک را به طور کامل در مقدار قرار دهید.',
                'value' => '3',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:38:51',
            ],
            4 =>
            [
                'id' => 5,
                'title' => 'کد اسکریپت همسان یکتانت',
                'description' => 'کد اسکریپت همسان یکتانت که در قسمت head قرار میگیرد.',
                'value' => '<script></script>',
                'created_at' => '2021-11-09 00:33:15',
                'updated_at' => '2021-11-09 00:38:51',
            ],
        ]);
    }
}
