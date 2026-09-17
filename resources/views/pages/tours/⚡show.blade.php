<?php

use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public Tour $tour;
    public string $travelDate = '';
    public int $guestCount = 2;

    public function mount(Tour $tour): void
    {
        abort_unless($tour->active, 404);
        $this->tour = $tour;
        $this->travelDate = now()->addDays(3)->toDateString();
    }

    public function incrementGuests(): void { $this->guestCount = min(10, $this->guestCount + 1); }
    public function decrementGuests(): void { $this->guestCount = max(1, $this->guestCount - 1); }

    public function continueBooking(): mixed
    {
        $this->validate(['travelDate' => ['required', 'date', 'after_or_equal:today'], 'guestCount' => ['required', 'integer', 'min:1', 'max:10']]);
        session(['booking.draft' => ['tour_id' => $this->tour->id, 'travel_date' => $this->travelDate, 'guest_count' => $this->guestCount]]);

        return $this->redirectRoute('booking.details', navigate: true);
    }
};
?>
<div><section class="relative h-[62vh] min-h-[560px] bg-forest"><img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="h-full w-full object-cover"><div class="absolute inset-0 bg-gradient-to-t from-forest/80 via-transparent to-forest/45"></div><div class="absolute inset-x-0 bottom-0 mx-auto max-w-7xl px-5 pb-12 text-white lg:px-8"><p class="text-xs font-semibold uppercase tracking-[.22em] text-lime">{{ $tour->eyebrow }}</p><h1 class="mt-4 max-w-4xl font-display text-5xl font-semibold tracking-[-.055em] sm:text-7xl">{{ $tour->name }}</h1><div class="mt-6 flex flex-wrap gap-5 text-sm text-white/75"><span>★ 4.9</span><span>{{ $tour->duration }}</span><span>{{ $tour->tour_type }}</span></div></div></section><section class="mx-auto grid max-w-7xl gap-14 px-5 py-20 lg:grid-cols-[1fr_380px] lg:px-8 lg:py-28"><div><p class="max-w-3xl font-display text-2xl leading-10 tracking-[-.025em] text-ink/80">{{ $tour->description }}</p><div class="mt-14 grid gap-12 sm:grid-cols-2"><div><h2 class="font-display text-2xl font-semibold">The route</h2><ol class="mt-6 space-y-4">@foreach ($tour->destinations as $index => $destination)<li wire:key="destination-{{ $index }}" class="flex gap-4 border-b border-ink/10 pb-4"><span class="text-xs text-leaf">0{{ $index + 1 }}</span><span>{{ $destination }}</span></li>@endforeach</ol></div><div><h2 class="font-display text-2xl font-semibold">What’s included</h2><ul class="mt-6 space-y-3 text-sm">@foreach ($tour->included as $item)<li wire:key="included-{{ $item }}" class="flex gap-3"><span class="text-leaf">✓</span>{{ $item }}</li>@endforeach</ul><h3 class="mt-9 text-sm font-semibold">Not included</h3><ul class="mt-4 space-y-2 text-sm text-ink/55">@foreach ($tour->excluded as $item)<li wire:key="excluded-{{ $item }}">— {{ $item }}</li>@endforeach</ul></div></div><div class="mt-16 grid grid-cols-3 gap-3">@foreach ($tour->gallery as $image)<img wire:key="gallery-{{ $loop->index }}" src="{{ $image }}" alt="{{ $tour->name }} gallery" class="aspect-square w-full rounded-xl object-cover">@endforeach</div></div><aside><form wire:submit="continueBooking" class="sticky top-6 rounded-2xl bg-white p-6 shadow-[0_25px_80px_rgba(23,61,46,.12)]"><p class="text-sm text-ink/50">From</p><p class="mt-1 font-display text-3xl font-semibold">{{ $tour->formatted_price }} <span class="font-sans text-sm font-normal text-ink/45">/ guest</span></p><label class="mt-7 block text-sm font-semibold" for="travel-date">Travel date</label><input id="travel-date" type="date" min="{{ now()->toDateString() }}" wire:model="travelDate" class="mt-2 w-full rounded-xl border border-ink/15 bg-transparent px-4 py-3 outline-none focus:border-leaf"><p class="mt-1 text-xs text-clay">@error('travelDate') {{ $message }} @enderror</p><div class="mt-6 flex items-center justify-between"><div><p class="text-sm font-semibold">Guests</p><p class="text-xs text-ink/45">Ages 3 and above</p></div><div class="flex items-center gap-4"><button type="button" wire:click="decrementGuests" class="grid size-9 place-items-center rounded-full border border-ink/15">−</button><span class="w-5 text-center font-semibold">{{ $guestCount }}</span><button type="button" wire:click="incrementGuests" class="grid size-9 place-items-center rounded-full border border-ink/15">+</button></div></div><div class="my-6 border-t border-ink/10"></div><div class="flex items-end justify-between"><span class="text-sm text-ink/55">Total</span><span class="font-display text-2xl font-semibold">Rp{{ number_format((float) $tour->price * $guestCount, 0, ',', '.') }}</span></div><button type="submit" class="mt-6 w-full rounded-full bg-forest px-5 py-4 font-semibold text-white transition hover:bg-leaf" wire:loading.attr="disabled">Continue booking <span wire:loading.remove>↗</span><span wire:loading>…</span></button><p class="mt-4 text-center text-xs text-ink/40">No payment needed yet</p></form></aside></section></div>
