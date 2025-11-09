<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(21, 45),
            'pictures' => [
                $this->faker->imageUrl(800, 1200, 'people'),
            ],
            'location' => $this->faker->city(),
            'likes_count' => 0,
        ];
    }
}
