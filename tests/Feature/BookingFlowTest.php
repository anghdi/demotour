<?php

use App\Models\Booking;
use App\Models\Tour;
use Database\Seeders\TourSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->withoutVite();
    $this->seed(TourSeeder::class);
});

test('customers can browse the tour catalogue and detail', function () {
    $tour = Tour::query()->firstOrFail();

    $this->get(route('home'))->assertOk()->assertSee('Go beyond');
    $this->get(route('tours.index'))->assertOk()->assertSee($tour->name);
    $this->get(route('tours.show', $tour))->assertOk()->assertSee('Continue booking');
});

test('guest count changes the displayed total', function () {
    $tour = Tour::query()->firstOrFail();

    Livewire::test('pages::tours.show', ['tour' => $tour])
        ->set('guestCount', 3)
        ->assertSee('Rp'.number_format((float) $tour->price * 3, 0, ',', '.'));
});

test('payment creates a paid booking and booking code', function () {
    $tour = Tour::query()->firstOrFail();
    $draft = ['tour_id' => $tour->id, 'travel_date' => now()->addWeek()->toDateString(), 'guest_count' => 2];
    $customer = ['customer_name' => 'Made Arya', 'customer_email' => 'made@example.com', 'customer_whatsapp' => '628123456789', 'customer_country' => 'Indonesia', 'special_request' => 'Vegetarian lunch'];

    $this->withSession(['booking.draft' => $draft, 'booking.customer' => $customer]);

    Livewire::test('pages::booking.payment')
        ->set('paymentMethod', 'QRIS')
        ->call('pay')
        ->assertRedirect(route('booking.success'));

    $booking = Booking::query()->sole();
    expect($booking->booking_code)->toStartWith('NP-')
        ->and($booking->payment_status->value)->toBe('PAID')
        ->and((int) $booking->total)->toBe((int) $tour->price * 2);
});
