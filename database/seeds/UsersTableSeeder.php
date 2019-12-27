<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

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


        Schema::enableForeignKeyConstraints();
    }
}
