<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Booking $booking;
    public string $status = '';

    public function mount(Booking $booking): void { $this->booking = $booking->load('tour'); $this->status = $booking->booking_status->value; }
    public function updateStatus(): void
    {
        $this->validate(['status' => ['required', Rule::enum(BookingStatus::class)]]);
        $this->booking->update(['booking_status' => $this->status]);
        $this->booking->refresh();
        session()->flash('status', 'Booking status updated.');
    }
};
?>

<div><a href="{{ route('admin.bookings.index') }}" wire:navigate class="text-sm text-ink/50">← Back to bookings</a><header class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-leaf">{{ $booking->booking_code }}</p><h1 class="mt-2 font-display text-3xl font-semibold tracking-[-.04em]">{{ $booking->customer_name }}</h1><p class="mt-2 text-sm text-ink/45">Booked {{ $booking->created_at->diffForHumans() }}</p></div><span class="w-fit rounded-full bg-lime/50 px-4 py-2 text-xs font-semibold">{{ $booking->payment_status->value }}</span></header>@if (session('status'))<div class="mt-6 rounded-xl bg-lime/40 px-4 py-3 text-sm text-forest">{{ session('status') }}</div>@endif<div class="mt-8 grid gap-6 lg:grid-cols-[1fr_340px]"><div class="space-y-6"><section class="rounded-2xl bg-white p-6"><h2 class="font-display text-xl font-semibold">Tour details</h2><dl class="mt-6 grid gap-6 text-sm sm:grid-cols-2"><div><dt class="text-ink/40">Tour</dt><dd class="mt-1 font-semibold">{{ $booking->tour->name }}</dd></div><div><dt class="text-ink/40">Travel date</dt><dd class="mt-1 font-semibold">{{ $booking->travel_date->format('l, d F Y') }}</dd></div><div><dt class="text-ink/40">Guests</dt><dd class="mt-1 font-semibold">{{ $booking->guest_count }}</dd></div><div><dt class="text-ink/40">Total</dt><dd class="mt-1 font-semibold">{{ $booking->formatted_total }}</dd></div></dl></section><section class="rounded-2xl bg-white p-6"><h2 class="font-display text-xl font-semibold">Customer</h2><dl class="mt-6 grid gap-6 text-sm sm:grid-cols-2"><div><dt class="text-ink/40">Email</dt><dd class="mt-1">{{ $booking->customer_email }}</dd></div><div><dt class="text-ink/40">WhatsApp</dt><dd class="mt-1">{{ $booking->customer_whatsapp }}</dd></div><div><dt class="text-ink/40">Country</dt><dd class="mt-1">{{ $booking->customer_country }}</dd></div><div><dt class="text-ink/40">Special request</dt><dd class="mt-1">{{ $booking->special_request ?: '—' }}</dd></div></dl></section></div><aside class="h-fit rounded-2xl bg-white p-6"><h2 class="font-display text-xl font-semibold">Manage booking</h2><form wire:submit="updateStatus" class="mt-6"><label for="status" class="text-sm font-semibold">Booking status</label><select id="status" wire:model="status" class="mt-2 w-full rounded-xl border border-ink/15 px-4 py-3"><option value="PENDING">Pending</option><option value="CONFIRMED">Confirmed</option><option value="COMPLETED">Completed</option><option value="CANCELLED">Cancelled</option></select><button class="mt-4 w-full rounded-full bg-forest px-5 py-3.5 font-semibold text-white">Update status</button></form><dl class="mt-7 space-y-3 border-t border-ink/10 pt-6 text-sm"><div class="flex justify-between"><dt class="text-ink/40">Payment</dt><dd>{{ $booking->payment_status->value }}</dd></div><div class="flex justify-between"><dt class="text-ink/40">Method</dt><dd>{{ str_replace('_', ' ', $booking->payment_method) }}</dd></div></dl></aside></div></div>
