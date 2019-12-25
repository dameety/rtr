<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Meal::class, function (Faker $faker) {

    $food = [
        'Cheese Pizza', 'Hamburger', 'Cheeseburger', 'Bacon Burger', 'Bacon Cheeseburger',
        'Little Hamburger', 'Little Cheeseburger', 'Little Bacon Burger', 'Little Bacon Cheeseburger',
        'Veggie Sandwich', 'Cheese Veggie Sandwich', 'Grilled Cheese',
        'Cheese Dog', 'Bacon Dog', 'Bacon Cheese Dog', 'Pasta', 'Chicken',
        'Bacon',
        'Sausage',
        'Beef',
        'Ham',
        'Hot dog',
        'Pork',
        'Turkey',
        'Chicken wing',
        'Chicken breast',
        'Lamb', 'Tomato sauce',
        'Tomato paste',
        'Mayonaise sauce',
        'BBQ sauce',
        'Chili sauce',
        'Garlic sauce',  'Corn',
        'Cucumber',
        'Pickle',
        'Avocado',
        'Pumpkin',
        'Mint',
        'Eggplant',
        'Yam', 'Egg',
        'Cheese',
        'Mozzarella',
    ];

    return [
        'name' => $faker->randomElement($food),
        'description' => $faker->sentence . $faker->sentence,
        'units' => $faker->randomDigitNotNull,
        'price' => $faker->randomFloat(2)
    ];

});
