<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class AuthenticationTest extends DuskTestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function test_user_can_login()
    {
        $user = factory(User::class)->create();


        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/auth/login')
                ->pause(200)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->pause(1000)
                ->assertPathIs('/admin/orders')
                ->assertSee('Orders');

        });
    }

    public function test_user_can_register()
    {
        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/auth/register')
                ->pause(200)
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->select('roles')
                ->type('password', 'password')
                ->press('Register')
                ->pause(700)
                ->assertPathIs('/admin/orders')
                ->assertSee('Orders');
        });

    }
}
