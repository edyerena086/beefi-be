<?php

use Illuminate\Database\Seeder;
use MetodikaTI\User;

class FakeUsersTableSeeder extends Seeder
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
                'name' => 'Webservice',
                'email' => 'ws@metodika.mx',
                'password' => bcrypt('Mku8njdro0@'),
                'user_group_id' => 1
            ]
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
