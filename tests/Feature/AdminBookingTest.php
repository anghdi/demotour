<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use Livewire\Livewire;

beforeEach(function () {
    $this->withoutVite();
});

test('admin pages redirect unauthenticated visitors to login', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

test('demo admin can sign in', function () {
    Livewire::test('pages::admin.login')
        ->set('email', config('tour.admin_email'))
        ->set('password', config('tour.admin_password'))
        ->call('login')
        ->assertRedirect(route('admin.dashboard'));
});

test('admin can update a booking status', function () {
    $booking = Booking::factory()->create();

    $this->withSession(['admin_authenticated' => true]);

    Livewire::test('pages::admin.bookings.show', ['booking' => $booking])
        ->set('status', BookingStatus::Confirmed->value)
        ->call('updateStatus')
        ->assertHasNoErrors();

    expect($booking->refresh()->booking_status)->toBe(BookingStatus::Confirmed);
});
