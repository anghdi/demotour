<?php

use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Private tours — Penida Way')] class extends Component
{
    public function with(): array
    {
        return ['tours' => Tour::query()->where('active', true)->orderBy('price')->get()];
    }
};
?>
<div><section class="bg-forest px-5 pb-20 pt-36 text-white lg:pb-24 lg:pt-44"><div class="mx-auto max-w-7xl"><p class="text-xs font-semibold uppercase tracking-[.25em] text-lime">Private island tours</p><h1 class="mt-5 max-w-4xl font-display text-5xl font-semibold tracking-[-.055em] sm:text-7xl">Pick a coast.<br>We’ll handle the road.</h1><p class="mt-7 max-w-xl leading-7 text-white/60">Thoughtful routes, private transport, and local guides. Choose the side of Nusa Penida that calls to you.</p></div></section><section class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"><div class="space-y-16">@foreach ($tours as $index => $tour)<article wire:key="tour-{{ $tour->id }}" class="grid items-center gap-8 lg:grid-cols-2 lg:gap-16"><a href="{{ route('tours.show', $tour) }}" wire:navigate class="group block overflow-hidden rounded-[1.5rem] {{ $index % 2 ? 'lg:order-2' : '' }}"><img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="aspect-[4/3] w-full object-cover transition duration-700 group-hover:scale-[1.03]"></a><div class="{{ $index % 2 ? 'lg:order-1' : '' }}"><p class="text-xs font-semibold uppercase tracking-[.2em] text-leaf">0{{ $index + 1 }} · {{ $tour->eyebrow }}</p><h2 class="mt-4 font-display text-4xl font-semibold tracking-[-.045em]">{{ $tour->name }}</h2><p class="mt-5 max-w-xl text-base leading-7 text-ink/60">{{ $tour->description }}</p><div class="mt-7 flex flex-wrap gap-5 text-sm"><span>{{ $tour->duration }}</span><span class="text-ink/30">/</span><span>{{ $tour->tour_type }}</span><span class="text-ink/30">/</span><span>From {{ $tour->formatted_price }}</span></div><a href="{{ route('tours.show', $tour) }}" wire:navigate class="mt-8 inline-flex border-b border-ink pb-1 text-sm font-semibold">View this tour ↗</a></div></article>@endforeach</div></section></div>
