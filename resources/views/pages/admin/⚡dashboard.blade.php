<?php

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public function logout(): mixed { session()->invalidate(); session()->regenerateToken(); return $this->redirectRoute('admin.login'); }
    public function with(): array
    {
        return ['stats' => ['total' => Booking::query()->count(), 'upcoming' => Booking::query()->whereDate('travel_date', '>=', today())->whereNot('booking_status', BookingStatus::Cancelled)->count(), 'completed' => Booking::query()->where('booking_status', BookingStatus::Completed)->count(), 'revenue' => Booking::query()->where('payment_status', PaymentStatus::Paid)->sum('total')], 'bookings' => Booking::query()->with('tour')->latest()->limit(6)->get()];
    }
};
?>

<div><header class="flex items-start justify-between"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-leaf">Overview</p><h1 class="mt-2 font-display text-3xl font-semibold tracking-[-.04em]">Good morning.</h1><p class="mt-2 text-sm text-ink/50">Here’s what’s happening with your tours.</p></div><button wire:click="logout" class="text-sm text-ink/50">Sign out</button></header><div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">@foreach ([['Total bookings',$stats['total']],['Upcoming',$stats['upcoming']],['Completed',$stats['completed']],['Paid revenue','Rp'.number_format($stats['revenue'],0,',','.')]] as [$label,$value])<div class="rounded-2xl bg-white p-6"><p class="text-xs uppercase tracking-[.14em] text-ink/40">{{ $label }}</p><p class="mt-4 font-display text-3xl font-semibold">{{ $value }}</p></div>@endforeach</div><section class="mt-10"><div class="flex items-end justify-between"><div><h2 class="font-display text-2xl font-semibold">Recent bookings</h2><p class="mt-1 text-sm text-ink/45">Latest customer activity</p></div><a href="{{ route('admin.bookings.index') }}" wire:navigate class="text-sm font-semibold text-leaf">View all ↗</a></div><div class="mt-5 overflow-x-auto rounded-2xl bg-white"><table class="w-full min-w-[760px] text-left text-sm"><thead class="border-b border-ink/10 text-xs uppercase tracking-[.12em] text-ink/40"><tr><th class="p-5">Booking</th><th>Customer</th><th>Tour</th><th>Date</th><th>Total</th><th>Status</th></tr></thead><tbody>@forelse ($bookings as $booking)<tr wire:key="booking-{{ $booking->id }}" class="border-b border-ink/5 last:border-0"><td class="p-5 font-semibold"><a href="{{ route('admin.bookings.show', $booking) }}" wire:navigate>{{ $booking->booking_code }}</a></td><td>{{ $booking->customer_name }}</td><td>{{ $booking->tour->name }}</td><td>{{ $booking->travel_date->format('d M Y') }}</td><td>{{ $booking->formatted_total }}</td><td><span class="rounded-full bg-lime/50 px-3 py-1 text-xs font-semibold">{{ $booking->booking_status->value }}</span></td></tr>@empty<tr><td colspan="6" class="p-10 text-center text-ink/40">No bookings yet.</td></tr>@endforelse</tbody></table></div></section></div>
