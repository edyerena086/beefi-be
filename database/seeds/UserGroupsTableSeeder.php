<?php

use Illuminate\Database\Seeder;
use MetodikaTI\UserGroup;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Client',
            ],

            [
                'name' => 'Admin',
            ],

            [
                'name' => 'Company',
            ]
        ];

        //Run the cycle
        foreach ($data as $item) {
            UserGroup::create($item);
        }
    }
}
