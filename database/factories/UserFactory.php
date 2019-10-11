<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {

    $rand_json = [
        'nums'=> [random_int(0,100), random_int(0,100), random_int(0,100), random_int(0,100)]
    ];
    return [
        'name' => $faker->name,
        'id_order' => random_int(0,100),
        'portrait_main' => random_int(0,50),
        'portraits' => json_encode($rand_json),
        'common_photos' => json_encode($rand_json),
    ];
});
