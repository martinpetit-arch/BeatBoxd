<?php

namespace Database\Factories;

use App\Models\Liste;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Liste>
 */
class ListeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nom' => fake()->sentence(3),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
