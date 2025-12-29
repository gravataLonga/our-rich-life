<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bucket>
 */
class BucketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->companySuffix() . ' ' . $this->faker->words(3, true),
            'goal' => $this->faker->numberBetween(50000, 3400000),
        ];
    }
}
