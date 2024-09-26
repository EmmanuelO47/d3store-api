<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\States;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                "id" => Str::uuid(),
                "name" => fake()->sentence(),
                "city_id" => City::factory(),
                "state_id" => States::factory(),
        ];
    }
}
