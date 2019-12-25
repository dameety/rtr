<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * Test registration
     */
    public function testDriverRegister()
    {

        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'role' => UserRole::DRIVER
        ];

        $response = $this->json('POST', route('apiV1.register'), $data);


        $response->assertOk()
                ->assertJsonFragment([
                    'email' =>  $data['email'],
                    'name' => $data['name'],
                    'role' => $data['role']
                ]);

        $response->assertSee('access_token');
    }

    /**
     * @test
     * Test registration
     */
    public function testCustomerRegister()
    {
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'role' => UserRole::CUSTOMER
        ];

        $response = $this->json('POST', route('apiV1.register'), $data);

        $response->assertOk()
                ->assertJsonFragment([
                    'email' =>  $data['email'],
                    'name' => $data['name'],
                    'role' => $data['role']
                ]);

        $response->assertSee('access_token');
    }

    /**
     * @test
     * Test registration
     */
    public function login()
    {
        $user = factory(User::class)->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->json('POST', route('apiV1.login'), $data);

        $response->assertOk()
                ->assertJsonFragment([
                    'email' =>  $user->email,
                    'name' => $user->name,
                    'role' => $user->role
                ]);

        $response->assertSee('access_token');
    }

    /**
     * @test
     * Test registration
     */
    public function lOgout()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', route('apiV1.logout'));

        $response->assertOk();
    }
}
