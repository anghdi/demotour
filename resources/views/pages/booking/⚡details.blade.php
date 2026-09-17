<?php

use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public Tour $tour;
    public array $draft = [];
    public string $fullName = '';
    public string $email = '';
    public string $whatsapp = '';
    public string $country = '';
    public string $specialRequest = '';

    public function mount(): void
    {
        $this->draft = session('booking.draft', []);
        abort_unless(isset($this->draft['tour_id']), 404);
        $this->tour = Tour::query()->findOrFail($this->draft['tour_id']);
        $customer = session('booking.customer', []);
        $this->fill(['fullName' => $customer['customer_name'] ?? '', 'email' => $customer['customer_email'] ?? '', 'whatsapp' => $customer['customer_whatsapp'] ?? '', 'country' => $customer['customer_country'] ?? '', 'specialRequest' => $customer['special_request'] ?? '']);
    }

    public function continueBooking(): mixed
    {
        $validated = $this->validate(['fullName' => ['required', 'string', 'max:100'], 'email' => ['required', 'email', 'max:150'], 'whatsapp' => ['required', 'string', 'max:30'], 'country' => ['required', 'string', 'max:80'], 'specialRequest' => ['nullable', 'string', 'max:1000']]);
        session(['booking.customer' => ['customer_name' => $validated['fullName'], 'customer_email' => $validated['email'], 'customer_whatsapp' => $validated['whatsapp'], 'customer_country' => $validated['country'], 'special_request' => $validated['specialRequest']]]);

        return $this->redirectRoute('booking.checkout', navigate: true);
    }
};
?>

<div><section class="bg-forest px-5 pb-12 pt-32 text-white"><div class="mx-auto max-w-5xl"><p class="text-xs font-semibold uppercase tracking-[.2em] text-lime">Booking · Step 1 of 3</p><h1 class="mt-4 font-display text-4xl font-semibold tracking-[-.045em]">Who’s joining us?</h1></div></section><section class="mx-auto grid max-w-5xl gap-10 px-5 py-14 lg:grid-cols-[1fr_300px]"><form wire:submit="continueBooking" class="space-y-6"><div class="grid gap-6 sm:grid-cols-2"><div class="sm:col-span-2"><label for="name" class="text-sm font-semibold">Full name *</label><input id="name" wire:model="fullName" autocomplete="name" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf">@error('fullName')<p class="mt-1 text-xs text-clay">{{ $message }}</p>@enderror</div><div><label for="email" class="text-sm font-semibold">Email *</label><input id="email" type="email" wire:model="email" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf">@error('email')<p class="mt-1 text-xs text-clay">{{ $message }}</p>@enderror</div><div><label for="whatsapp" class="text-sm font-semibold">WhatsApp number *</label><input id="whatsapp" wire:model="whatsapp" placeholder="+62 812…" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf">@error('whatsapp')<p class="mt-1 text-xs text-clay">{{ $message }}</p>@enderror</div><div class="sm:col-span-2"><label for="country" class="text-sm font-semibold">Country *</label><input id="country" wire:model="country" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf">@error('country')<p class="mt-1 text-xs text-clay">{{ $message }}</p>@enderror</div><div class="sm:col-span-2"><label for="request" class="text-sm font-semibold">Special request <span class="font-normal text-ink/40">(optional)</span></label><textarea id="request" wire:model="specialRequest" rows="4" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf"></textarea></div></div><button type="submit" class="rounded-full bg-forest px-7 py-4 font-semibold text-white hover:bg-leaf">Continue to review ↗</button></form><aside class="h-fit rounded-2xl bg-white p-5"><img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="aspect-[16/10] w-full rounded-xl object-cover"><h2 class="mt-5 font-display text-lg font-semibold">{{ $tour->name }}</h2><dl class="mt-4 space-y-3 text-sm"><div class="flex justify-between"><dt class="text-ink/50">Date</dt><dd>{{ \Illuminate\Support\Carbon::parse($draft['travel_date'])->format('d M Y') }}</dd></div><div class="flex justify-between"><dt class="text-ink/50">Guests</dt><dd>{{ $draft['guest_count'] }}</dd></div><div class="flex justify-between border-t border-ink/10 pt-3 font-semibold"><dt>Total</dt><dd>Rp{{ number_format((float) $tour->price * $draft['guest_count'], 0, ',', '.') }}</dd></div></dl></aside></section></div>
