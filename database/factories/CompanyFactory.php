<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'NIP' => fake()->numberBetween(1000000000, 9999999999),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postCode' => fake()->postcode(),
        ];
    }
}