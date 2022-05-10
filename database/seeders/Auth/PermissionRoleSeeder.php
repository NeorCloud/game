<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        if (Role::count() == 0) {
            Role::create([
                'id' => 1,
                'type' => User::TYPE_ADMIN,
                'name' => 'Administrator',
            ]);
            $this->truncateMultiple([
                config('permission.table_names.model_has_roles'),
                config('permission.table_names.role_has_permissions'),
            ]);
            $this->call(UserRoleSeeder::class);
        }

        // Non Grouped Permissions
        //

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.logs',
            'description' => 'Logs Permission',
        ]);

        Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.settings',
            'description' => 'Settings Permission',
        ]);

        Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.files',
            'description' => 'Files Permission',
        ]);

        Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.backups',
            'description' => 'Backups Permission',
        ]);

        Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.games',
            'description' => 'Games Permission',
        ]);

        $this->enableForeignKeys();
    }
}
