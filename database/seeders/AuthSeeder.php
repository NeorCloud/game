<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Auth\PermissionRoleSeeder;
use Database\Seeders\Auth\UserRoleSeeder;
use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;

/**
 * Class AuthTableSeeder.
 */
class AuthSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Reset cached roles and permissions
        Artisan::call('cache:clear');
        resolve(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->truncateMultiple([
            config('permission.table_names.permissions'),
        ]);

        if (User::count() == 0) {
            $this->truncateMultiple([
                'users',
                'password_histories',
                'password_resets',
            ]);
            $this->call(UserSeeder::class);
        }
        $this->call(PermissionRoleSeeder::class);

        $this->enableForeignKeys();
    }
}
