<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('orders')->delete();

        Schema::enableForeignKeyConstraints();
    }
}
