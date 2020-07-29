<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ParkingContract;
use App\Owner;
use App\Vehicle;
use App\Plan;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

$factory->define(ParkingContract::class, function (Faker $faker) {
    return [
        'owner_id' => Owner::inRandomOrder()->first()->document_number,
        'vehicle_id' => Vehicle::inRandomOrder()->first()->plate_number,
        'plan_id' => Plan::inRandomOrder()->first()->id,
        'start_date_plan' => Carbon::now(),
        'finish_date_plan' => $faker->dateTime($max = 'now', $timezone = null),
        'is_active' => true
    ];
});