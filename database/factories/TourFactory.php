<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(3),
            'eyebrow' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(600000, 1200000),
            'duration' => '8–10 hours',
            'tour_type' => 'Private tour',
            'image' => 'https://images.unsplash.com/photo-1573790387438-4da905039392',
            'gallery' => [],
            'destinations' => fake()->words(4),
            'included' => ['Private car', 'Local guide'],
            'excluded' => ['Lunch'],
            'active' => true,
        ];
    }
}
