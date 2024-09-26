<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\States;
use App\Models\City;
use App\Models\Location;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->company(),
            "address" => fake()->address(),
            "state" => '6de3150d-c410-44cf-9285-30111cc5b663',
            "city" => '609174f7-a1aa-4e47-b312-d2dd75578642',
            "location" => '53bf3107-7c45-4794-87a4-2923c1b895c3',
            "email" => fake()->email(),
            "contact_person" => fake()->name(),
            "phone" => fake()->numerify('080########'),
            "account_number" => fake()->numerify('##########'),
            "bank" => fake()->company(),
            "account_name" => fake()->company(),
            "created_at" => fake()->dateTimeThisMonth(),
            "updated_at" => fake()->dateTimeThisMonth(),
        ];
    }
}
