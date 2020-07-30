<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plan;
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

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'name' => 'Test plan reference [' . Str::random(6) . ']',
        'description' => $faker->text($maxNbChars = 50),
        'has_daily_payment' => (bool) random_int(0, 1),
        'daily_payment_charge' => $faker->randomFloat(2, 0, 200),
        'has_monthly_dynamic_payment' => (bool) random_int(0, 1),
        'monthly_dynamic_payment_charge' => $faker->randomFloat(2, 0, 200),
        'has_monthly_static_payment' => (bool) random_int(0, 1),
        'monthly_static_payment_charge' => $faker->randomFloat(2, 0, 1000000),
    ];
});


