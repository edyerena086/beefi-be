<?php

use Illuminate\Database\Seeder;
use MetodikaTI\Gender;

class GendersTableSeeder extends Seeder
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
                'name' => 'Femenino'
            ],

            [
                'name' => 'Masculino'
            ]
        ];

        foreach ($data as $item) {
            Gender::create($item);
        }
    }
}
