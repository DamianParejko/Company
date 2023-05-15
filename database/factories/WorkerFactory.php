<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
        ];
    }

    public function companyId($companyId)
    {
        return $this->state(function () use ($companyId) {
            return [
                'company_id' => $companyId,
            ];
        });
    }
}