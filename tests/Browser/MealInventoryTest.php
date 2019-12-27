<?php

namespace Tests\Browser;

use App\Meal;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MealInventoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install', ['-vvv' => true]);
        $this->user = factory(User::class)->states('admin')->create();
    }

    public function test_can_view_all_meals()
    {
        $meals = ['Bread Cheese', 'Blown Meat'];
        foreach($meals as $food) {
            factory(Meal::class)->create(['name' => $food]);
        }

        $this->browse(function (Browser $browser) use ($meals) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $this->user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/admin/meals')
                ->pause(500);
                foreach($meals as $meal) {
                    $browser->assertSee($meal);
                }
        });
    }

    public function test_can_view_a_meal()
    {
        $meal = factory(Meal::class)->create(['name' => 'Blwon meat Syrup']);

        $this->browse(function (Browser $browser) use ($meal) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $this->user->email)
                ->type('password', 'password')
                ->press('Login')
                ->visit("/admin/meals")
                ->pause(500)
                ->click("@action-dropdown")
                ->pause(500)
                ->click("@edit-meal-{$meal->id}")
                ->pause(1000)
                ->assertPathIs("/admin/inventory/{$meal->id}/edit")
                ->assertSee($meal->units)
                ->assertSee($meal->name);
        });
    }


    public function test_meal_can_be_deleted()
    {
        $meal = factory(Meal::class)->create(['name' => 'Oyan']);

        $this->browse(function (Browser $browser) use ( $meal) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $this->user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/admin/meals')
                ->pause(500)
                ->click("@action-dropdown")
                ->pause(500)
                ->click("@delete-meal-{$meal->id}")
                ->pause(1000)
                ->whenAvailable('.modal-dialog', function ($modal) {
                    $modal->assertSee('Yes! Delete it')
                        ->press('Yes! Delete it')
                        ->pause(1000);
                })
                ->assertDontSee($meal->name);
        });
    }
}
