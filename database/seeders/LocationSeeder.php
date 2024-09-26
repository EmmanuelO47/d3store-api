<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\City;
use Illuminate\Support\Str;


class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::truncate();
        $locations = [
            ["id"=>Str::uuid(),"state_id"=>"fc162fb5-88ce-4e9e-ae43-1c12aa8732cf","city_id"=>"609174f7-a1aa-4e47-b312-d2dd75578642", "name"=>"Ogolonto"],
            ["id"=>Str::uuid(), "state_id"=>"fc162fb5-88ce-4e9e-ae43-1c12aa8732cf","city_id"=>"609174f7-a1aa-4e47-b312-d2dd75578642","name"=>"Sabo"],
        ];
        Location::insert($locations);
    }
}
