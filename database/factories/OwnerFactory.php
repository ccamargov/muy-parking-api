<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Owner;
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

$factory->define(Owner::class, function (Faker $faker) {
    return [
        'document_number' => Str::random(11),
        'names' => $faker->name,
        'surnames' => $faker->name,
        'tel_contact' => $faker->tollFreePhoneNumber,
        'email_contact' => $faker->email,
        'is_resident' => (bool) random_int(0, 1)
    ];
});