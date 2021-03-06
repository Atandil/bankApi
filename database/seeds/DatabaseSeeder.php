<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Customer::class, 2)->create();
        factory(App\Transaction::class, 10)->create();
        factory(App\User::class, 5)->create();
    }
}
