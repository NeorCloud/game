<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'type' => User::TYPE_ADMIN,
            'first_name' => 'Mohammad',
            'last_name' => 'Salmani',
            'email' => 'mohammadsalmani28@gmail.com',
            'password' => 'secret',
            'email_verified_at' => now(),
            'active' => true,
        ]);

        $this->enableForeignKeys();
    }
}
