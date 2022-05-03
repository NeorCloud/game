<?php

namespace Database\Seeders;

use App\Domains\Settings\Models\Setting;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'activity_log',
            'failed_jobs',
        ]);

        $this->call(AuthSeeder::class);
//        $this->call(AnnouncementSeeder::class);

        Model::reguard();
        if (Setting::count() == 0) {
            $this->call(SettingsTableSeeder::class);
        }
        $this->call(GamesTableSeeder::class);
    }
}
