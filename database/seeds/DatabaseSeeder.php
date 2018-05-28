<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserGroupsTableSeeder::class);

        // $this->call(UsersTableSeeder::class);

        // $this->call(GendersTableSeeder::class);
        
        $this->call(NetworkPasswordsSeeder::class);

        /**
         * -----------------------------------------------------------------------------------------
         *  Fake Data for development and qa purpose
         * -----------------------------------------------------------------------------------------
         */

        // $this->call(FakeUsersTableSeeder::class);
    }
}
