<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\States;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //States::factory()->create();
        $this->call([
           // StatesSeeder::class,
           // CitySeeder::class,
           // LocationSeeder::class,
          // StoreSeeder::class,
          ProductsSeeder::class,
        ]);
    }
}
