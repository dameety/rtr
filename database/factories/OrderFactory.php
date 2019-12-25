<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Meal;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {

    return [
        'address' => $faker->streetAddress,
        'user_id' => factory(\App\User::class)->create()->id,
        'driver_id' => null,
        'delivered_at' => null,
        'total_amount' => $faker->randomDigitNotNull,
        'cart' => json_encode([]),
        'status' => $faker->randomElement(\App\Enums\OrderStatus::getValues())
    ];

});
