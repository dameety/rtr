<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->delete();

        Artisan::call('passport:install', [
            '--force' => true,
        ]);

        factory(User::class)->create([
            'email' => 'admin@restaurant.test',
            'role' => \App\Enums\UserRole::ADMIN
        ]);

        factory(User::class, 5)->create([
            'role' => \App\Enums\UserRole::DRIVER
        ]);

        factory(User::class, 5)->create([
            'role' => \App\Enums\UserRole::CUSTOMER
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
