<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vehicle;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'plate_number' => Str::random(6),
        'color' => $faker->safeColorName,
        'brand' => Str::random(10),
        'type' => Str::random(10),
        'model' => $faker->year($max = 'now'),
        'chassis_number' => Str::random(17),
        'is_vip' => (bool) random_int(0, 1)
    ];
});