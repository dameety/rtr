<?php

use App\Meal;
use Illuminate\Database\Seeder;

class MealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('meals')->delete();

        $food = [
            'Cheese Pizza', 'Hamburger', 'Cheeseburger', 'Bacon Burger',
            'Little Hamburger', 'Little Cheeseburger', 'Little Bacon Burger',
            'Veggie Sandwich', 'Cheese Veggie Sandwich', 'Grilled Cheese',
            'Cheese Dog', 'Bacon Dog', 'Pasta'
        ];

        $faker = \Faker\Factory::create();

        foreach($food as $meal) {
            Meal::create([
                'name' => $meal,
                'units' => $faker->randomDigitNotNull,
                'description' => $faker->sentence,
                'price' => $faker->numberBetween(500, 1000)
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
