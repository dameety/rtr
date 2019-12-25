<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        Artisan::call('passport:install', ['-vvv' => true]);
    }

    protected function signIn($state = 'admin', $user = null)
    {
        $user = $user ?: factory('App\User')->states($state)->create();

        $this->actingAs($user, 'api');

        return $user;
    }

}
