<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::truncate();
        $cities = [
            ["id"=>Str::uuid(),"state_id"=>"fc162fb5-88ce-4e9e-ae43-1c12aa8732cf", "name"=>"Ikorodu"],
            ["id"=>Str::uuid(), "state_id"=>"fc162fb5-88ce-4e9e-ae43-1c12aa8732cf","name"=>"Ketu"],
        ];
        City::insert($cities);
    }
}
