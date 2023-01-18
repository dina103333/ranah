<?php

namespace Database\Seeders;

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
        // factory(App\Admin::class, 5000)->create();
        \App\Models\Admin::factory()->count(5000)->create();
        // \App\Models\User::factory(10)->create();
    }
}
