<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_code' => 'NP-'.now()->format('Ymd').'-'.fake()->unique()->numerify('###'),
            'tour_id' => Tour::factory(),
            'travel_date' => fake()->dateTimeBetween('+1 day', '+2 months'),
            'guest_count' => fake()->numberBetween(1, 6),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_whatsapp' => fake()->numerify('62812########'),
            'customer_country' => fake()->country(),
            'special_request' => fake()->optional()->sentence(),
            'subtotal' => 1300000,
            'total' => 1300000,
            'payment_method' => 'BANK_TRANSFER',
            'payment_status' => PaymentStatus::Paid,
            'booking_status' => BookingStatus::Pending,
        ];
    }
}
