<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(MetodikaTI\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(MetodikaTI\Beefispot::class, function (Faker\Generator $faker) {
	return [
		'title' => $faker->company,
		'description' => $faker->sentence,
		'lat' => $faker->latitude(),
		'lng' => $faker->longitude()
	];
});

$factory->define(MetodikaTI\Sponsor::class, function (Faker\Generator $faker) {
    return [
        'company_name' => $faker->company,
        'sponsor_ad' => rand(1000000, 9999999).'.jpg',
    ];
});
