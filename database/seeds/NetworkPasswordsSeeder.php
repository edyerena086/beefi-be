<?php

use MetodikaTI\NetworkPassword;
use Illuminate\Database\Seeder;

class NetworkPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	['password' => 'b&@cucaFaq8Q']
        ];

        foreach ($data as $item) {
        	NetworkPassword::create($item);
        }
    }
}
