<?php

namespace Tests\Feature;

use App\Meal;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MealApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function a_meal_can_be_created()
    {
        $data = factory(Meal::class)->make([
            'name' => 'Cheese Pizza'
        ])->toArray();

        $this->signIn();
        $response = $this->json('POST', route('apiV1.meals.store'), $data);

        $response->assertOk()
                ->assertJsonFragment([
                    'name' =>  $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'units' => $data['units']
                ]);

        $this->assertDatabaseHas('meals', $data);
    }

    /**
     * @test
     */
    public function a_meal_can_be_updated()
    {
        $meal = factory(Meal::class)->create([
            'name' => 'Cheese Veggie Sandwich'
        ]);
        $data = factory(Meal::class)->make([
            'name' => 'Pasta'
        ])->toArray();

        $this->signIn();
        $response = $this->json('PUT', route('apiV1.meals.update', $meal->id), $data);

        $response->assertOk()
                ->assertJsonFragment([
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'units' => $data['units']
                ]);

        unset( $data['name'] );

        $this->assertDatabaseHas('meals', $data);
    }


    /**
     * @test
     */
    public function a_meal_can_be_deleted()
    {
        $meal = factory(Meal::class)->create([
            'name' => 'Little Cheese Burger'
        ]);

        $this->signIn();
        $response = $this->json('DELETE', route('apiV1.meals.destroy', $meal->id));

        $response->assertOk();
        $this->assertDatabaseMissing('meals', $meal->toArray());
    }

    /**
     * @test
     */
    public function can_get_a_list_of_meals()
    {
        $foods = [
            'Cheeseburger', 'Bacon Burger', 'Bacon Cheeseburger',
            'Little Hamburger', 'Little Cheeseburger',
            'Veggie Sandwich', 'Grilled Cheese',
            'Cheese Dog','Bacon Cheese Dog'
        ];
        $data = [];
        foreach($foods as $food) {
            $meal = factory(Meal::class)->create([
                'name' => $food
            ]);

            array_push($data, $meal);
        }

        $this->signIn();
        $response = $this->json('GET', route('apiV1.meals.index'));

        $response->assertOk();
        foreach ($data as $meal) {
            $this->assertDatabaseHas('meals', ['name' => $meal->name]);
        }
    }

}
