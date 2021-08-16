<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      \App\Models\User::factory(5)->create();
      \App\Models\Company::factory(5)->create();
      \App\Models\Product::factory(7)->create();
      \App\Models\Sale::factory(5)->create();

    }
}
