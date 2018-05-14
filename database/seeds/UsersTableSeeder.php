<?php

use MetodikaTI\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        		'name' => 'Demon',
        		'email' => 'demon@metodika.com.mx',
        		'password' => bcrypt('Mku8njdro0@'),
        		'user_group_id' => 2
        	]
        ];

        foreach ($data as $item) {
        	User::create($item);
        }
    }
}
