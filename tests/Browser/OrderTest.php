<?php

namespace Tests\Browser;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Meal;
use App\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class OrderTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install', ['-vvv' => true]);
    }

    public function test_user_can_make_order()
    {
        $foods = ['Bread Cheese', 'Blown Meat'];
        foreach($foods as $food) {
            factory(Meal::class)->create(['name' => $food]);
        }

        $user = factory(User::class)->create();

        $order = factory(Order::class)->make();

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/')
                ->pause(500)
                ->click('@add-to-cart-button')
                ->waitForText('Address')
                ->type('address', $order->address)
                ->click('@submit-checkout')
                ->pause(500)
                ->assertSee('Order successfully created');
            $this->assertDatabaseHas('orders', [
                'address' => $order->address
            ]);
        });
    }

    public function test_customer_can_view_an_order()
    {
        $user = factory('App\User')->states('customer')->create();

        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'cart' => json_encode([factory(Meal::class)->make(['name' => 'Oyam'])])
        ]);


        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/admin/orders')
                ->pause(500)
                ->click("@action-dropdown")
                ->pause(200)
                ->click("@view-order-{$order->id}")
                ->assertPathIs("/admin/orders/{$order->id}/show")
                ->pause(500)
                ->assertSee($order->customer->name);
        });
    }

    public function test_order_can_be_updated()
    {
        $user = factory('App\User')->create();
        $driver = factory('App\User', 2)->create([
            'role' => UserRole::DRIVER
        ])->random();

        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'cart' => json_encode([factory(Meal::class)->make(['name' => 'Oyam'])])
        ]);

        $this->browse(function (Browser $browser) use ($user, $order, $driver) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(500)
                ->visit("/admin/orders/{$order->id}/edit")
                ->assertSee($order->customer->name)
                ->assertSee($order->customer->email)
                ->select('drivers', $driver->id)
                ->click("@update-order")
                ->pause(1000)
                ->assertSee('Success');
        });
    }

    public function test_admin_can_delete_order()
    {
        $user = factory('App\User')->state('admin')->create();

        $order = factory(Order::class)->create([
            'user_id' => $user->id,
            'cart' => json_encode([factory(Meal::class)->make(['name' => 'Orice'])])
        ]);

        $this->browse(function (Browser $browser) use ($user, $order) {
            $browser->visit('/auth/login')
                ->pause(500)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->visit('/admin/orders')
                ->pause(500)
                ->click("@action-dropdown")
                ->pause(500)
                ->click("@delete-order-{$order->id}")
                ->pause(1000)
                ->whenAvailable('.modal-dialog', function ($modal) use ($order) {
                    $modal->assertSee('Yes! Delete it')
                        ->press('Yes! Delete it')
                        ->pause(1000);
                    })
                ->assertDontSee($order->customer->name);
        });
    }

}
