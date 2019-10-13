<?php
//namespace App\Models;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         factory(App\Models\Order::class, 100)->create();
         factory(App\Models\OrderUser::class, 500)->create();
    }
}
