<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {

    return [
        'name' => $faker->address,
        'portraits_count' => random_int(0,5),
        'photo_common' => random_int(0,60),
        'photo_individual' => random_int(0,40),
        'client_link' => env('APP_URL').'/order/'.substr(md5(mt_rand(0, 100).$faker->hexColor), 0, 10),
        'confirm_key' => substr(md5(mt_rand(0, 100).$faker->hexColor), 0, 10),
        'comment' => $faker->text(random_int(10, 100))
    ];
});
