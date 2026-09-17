<?php

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public Booking $booking;

    public function mount(): void
    {
        $bookingId = session('booking.completed_id');
        abort_unless($bookingId, 404);
        $this->booking = Booking::query()->with('tour')->findOrFail($bookingId);
    }

    public function whatsappUrl(): string
    {
        $message = "Hi, I have made a booking.\n\nBooking ID: {$this->booking->booking_code}\nTour: {$this->booking->tour->name}\nDate: {$this->booking->travel_date->format('d F Y')}\n\nI would like to confirm my booking.";

        return 'https://wa.me/'.config('tour.whatsapp_number').'?text='.rawurlencode($message);
    }
};
?>

<div class="bg-forest px-5 pb-24 pt-32 text-white"><section class="mx-auto max-w-2xl text-center"><div class="mx-auto grid size-20 place-items-center rounded-full bg-lime text-3xl text-forest">✓</div><p class="mt-8 text-xs font-semibold uppercase tracking-[.22em] text-lime">Payment received</p><h1 class="mt-4 font-display text-5xl font-semibold tracking-[-.05em]">Booking confirmed.</h1><p class="mt-5 text-white/60">Your Penida adventure is on the calendar. Save your booking ID below.</p><div class="mt-10 rounded-2xl bg-white p-6 text-left text-ink md:p-8"><div class="flex items-center justify-between border-b border-ink/10 pb-6"><span class="text-sm text-ink/45">Booking ID</span><strong class="font-display text-xl">{{ $booking->booking_code }}</strong></div><dl class="mt-6 space-y-4 text-sm"><div class="flex justify-between gap-6"><dt class="text-ink/45">Tour</dt><dd class="text-right font-semibold">{{ $booking->tour->name }}</dd></div><div class="flex justify-between"><dt class="text-ink/45">Date</dt><dd>{{ $booking->travel_date->format('d F Y') }}</dd></div><div class="flex justify-between"><dt class="text-ink/45">Guests</dt><dd>{{ $booking->guest_count }}</dd></div><div class="flex justify-between"><dt class="text-ink/45">Total</dt><dd>{{ $booking->formatted_total }}</dd></div><div class="flex justify-between"><dt class="text-ink/45">Payment</dt><dd class="rounded-full bg-lime px-3 py-1 text-xs font-semibold text-forest">PAID</dd></div></dl></div><div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row"><a href="{{ $this->whatsappUrl() }}" target="_blank" class="rounded-full bg-lime px-6 py-3.5 font-semibold text-forest">Confirm on WhatsApp ↗</a><a href="{{ route('home') }}" class="rounded-full border border-white/30 px-6 py-3.5 font-semibold text-white">Back to home</a></div></section></div>
