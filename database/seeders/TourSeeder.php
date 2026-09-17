<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = [
            [
                'name' => 'West Nusa Penida Tour',
                'slug' => 'west-nusa-penida-tour',
                'eyebrow' => 'Cliffs & coves',
                'description' => 'Follow the island’s dramatic western coastline, from the unmistakable curve of Kelingking to calm, clear water at Crystal Bay. A private day shaped around unhurried stops and local insight.',
                'price' => 650000,
                'duration' => '8–10 hours',
                'tour_type' => 'Private tour',
                'image' => 'https://images.unsplash.com/photo-1573790387438-4da905039392?auto=format&fit=crop&w=1800&q=85',
                'gallery' => [
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1533669955142-6a73332af4db?auto=format&fit=crop&w=1200&q=85',
                ],
                'destinations' => ['Kelingking Beach', 'Broken Beach', 'Angel’s Billabong', 'Crystal Bay'],
                'included' => ['Private air-conditioned car', 'Local driver & guide', 'Fuel', 'Parking fees', 'Mineral water'],
                'excluded' => ['Lunch', 'Island entry ticket', 'Personal expenses'],
                'active' => true,
            ],
            [
                'name' => 'East Nusa Penida Tour',
                'slug' => 'east-nusa-penida-tour',
                'eyebrow' => 'Wild east coast',
                'description' => 'Start early for the soft morning light at Diamond Beach, then trace Nusa Penida’s quieter eastern edge through hidden coves, hilltop views, and rolling green landscapes.',
                'price' => 700000,
                'duration' => '8–10 hours',
                'tour_type' => 'Private tour',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1800&q=85',
                'gallery' => [
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=85',
                ],
                'destinations' => ['Diamond Beach', 'Atuh Beach', 'Tree House', 'Teletubbies Hill'],
                'included' => ['Private air-conditioned car', 'Local driver & guide', 'Fuel', 'Parking fees', 'Mineral water'],
                'excluded' => ['Lunch', 'Island entry ticket', 'Personal expenses'],
                'active' => true,
            ],
            [
                'name' => 'West + East Nusa Penida',
                'slug' => 'west-east-nusa-penida',
                'eyebrow' => 'The complete island',
                'description' => 'For curious travellers with one full day, this private route combines the island’s icons with a carefully timed cross-island itinerary and plenty of room to take it all in.',
                'price' => 950000,
                'duration' => '10–12 hours',
                'tour_type' => 'Private full day',
                'image' => 'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8?auto=format&fit=crop&w=1800&q=85',
                'gallery' => [
                    'https://images.unsplash.com/photo-1573790387438-4da905039392?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85',
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?auto=format&fit=crop&w=1200&q=85',
                ],
                'destinations' => ['Kelingking Beach', 'Broken Beach', 'Diamond Beach', 'Tree House'],
                'included' => ['Private air-conditioned car', 'Local driver & guide', 'Fuel', 'Parking fees', 'Mineral water'],
                'excluded' => ['Lunch', 'Island entry ticket', 'Personal expenses'],
                'active' => true,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::query()->updateOrCreate(['slug' => $tour['slug']], $tour);
        }
    }
}
