<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        User::find(1)->assignRole(config('access.users.admin_role'));
        User::find(2)->assignRole(config('access.users.user_role'));
        User::find(3)->assignRole(config('access.users.owner_role'));
        User::find(4)->assignRole(config('access.users.owner_role'));
        User::find(5)->assignRole(config('access.users.owner_role'));
        User::find(6)->assignRole(config('access.users.box_admin_role'));
        User::find(7)->assignRole(config('access.users.coach_role'));
        User::find(8)->assignRole(config('access.users.coach_role'));
        User::find(9)->assignRole(config('access.users.coach_role'));

        $this->enableForeignKeys();
    }
}
