<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\OrderUser::class, function (Faker $faker) {
    $rand_json = [
        'nums'=> [random_int(0,100), random_int(0,100), random_int(0,100), random_int(0,100)]
    ];
    return [
        'name' => $faker->name,
        'id_order' => random_int(1,100),
        'portrait_main' => random_int(0,50),
        'portraits' => json_encode($rand_json),
        'common_photos' => json_encode($rand_json),
        'comment' => $faker->text(100),
        'designs' => json_encode($rand_json),
    ];
});
