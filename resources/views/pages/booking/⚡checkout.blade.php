<?php

use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public Tour $tour;
    public array $draft = [];
    public array $customer = [];

    public function mount(): void
    {
        $this->draft = session('booking.draft', []);
        $this->customer = session('booking.customer', []);
        abort_unless(isset($this->draft['tour_id'], $this->customer['customer_email']), 404);
        $this->tour = Tour::query()->findOrFail($this->draft['tour_id']);
    }
};
?>

<div><section class="bg-forest px-5 pb-12 pt-32 text-white"><div class="mx-auto max-w-4xl"><p class="text-xs font-semibold uppercase tracking-[.2em] text-lime">Booking · Step 2 of 3</p><h1 class="mt-4 font-display text-4xl font-semibold tracking-[-.045em]">Review your island day.</h1></div></section><section class="mx-auto max-w-4xl px-5 py-14"><div class="overflow-hidden rounded-2xl bg-white"><div class="grid md:grid-cols-[260px_1fr]"><img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="h-full min-h-56 w-full object-cover"><div class="p-6 md:p-8"><p class="text-xs font-semibold uppercase tracking-[.16em] text-leaf">{{ $tour->tour_type }}</p><h2 class="mt-2 font-display text-2xl font-semibold">{{ $tour->name }}</h2><dl class="mt-6 grid gap-5 text-sm sm:grid-cols-2"><div><dt class="text-ink/45">Travel date</dt><dd class="mt-1 font-semibold">{{ \Illuminate\Support\Carbon::parse($draft['travel_date'])->format('l, d F Y') }}</dd></div><div><dt class="text-ink/45">Guests</dt><dd class="mt-1 font-semibold">{{ $draft['guest_count'] }} guests</dd></div></dl></div></div><div class="grid gap-8 border-t border-ink/10 p-6 md:grid-cols-2 md:p-8"><div><div class="flex items-center justify-between"><h3 class="font-display text-lg font-semibold">Guest details</h3><a href="{{ route('booking.details') }}" wire:navigate class="text-xs font-semibold text-leaf">Edit</a></div><p class="mt-4 text-sm font-semibold">{{ $customer['customer_name'] }}</p><p class="mt-1 text-sm text-ink/55">{{ $customer['customer_email'] }}</p><p class="mt-1 text-sm text-ink/55">{{ $customer['customer_whatsapp'] }} · {{ $customer['customer_country'] }}</p>@if ($customer['special_request'])<p class="mt-4 text-sm italic text-ink/55">“{{ $customer['special_request'] }}”</p>@endif</div><div class="space-y-3 text-sm"><div class="flex justify-between"><span class="text-ink/50">{{ $tour->formatted_price }} × {{ $draft['guest_count'] }}</span><span>Rp{{ number_format((float) $tour->price * $draft['guest_count'], 0, ',', '.') }}</span></div><div class="flex justify-between border-t border-ink/10 pt-4 font-display text-xl font-semibold"><span>Total</span><span>Rp{{ number_format((float) $tour->price * $draft['guest_count'], 0, ',', '.') }}</span></div></div></div></div><a href="{{ route('booking.payment') }}" wire:navigate class="mt-8 block w-full rounded-full bg-forest px-7 py-4 text-center font-semibold text-white hover:bg-leaf">Continue to payment ↗</a><p class="mt-4 text-center text-xs text-ink/40">This demo uses a simulated payment. No real charge will be made.</p></section></div>
