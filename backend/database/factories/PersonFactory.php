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
        $fallbackPictures = [
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1887&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1887&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1524503033411-c9566986fc8f?q=80&w=1887&auto=format&fit=crop',
        ];

        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(21, 45),
            'pictures' => $fallbackPictures,
            'location' => $this->faker->city(),
            'likes_count' => 0,
        ];
    }
}
