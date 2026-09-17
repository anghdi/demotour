<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Private Nusa Penida tours, thoughtfully guided by locals.">
    <title>{{ $title ?? 'Penida Way — Private island tours' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Manrope:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-sand text-ink antialiased">
    <header class="absolute inset-x-0 top-0 z-40" x-data="{ open: false }">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-6 lg:px-8">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 text-white" aria-label="Penida Way home"><span class="grid size-9 place-items-center rounded-full border border-white/50 text-sm font-semibold">P</span><span class="font-display text-lg font-semibold tracking-[-0.03em]">Penida Way</span></a>
            <nav class="hidden items-center gap-8 text-sm font-medium text-white/85 md:flex"><a href="{{ route('home') }}" wire:navigate class="transition hover:text-white">Home</a><a href="{{ route('tours.index') }}" wire:navigate class="transition hover:text-white">Tours</a><a href="{{ route('home') }}#about" class="transition hover:text-white">About</a><a href="{{ route('home') }}#gallery" class="transition hover:text-white">Gallery</a><a href="https://wa.me/{{ config('tour.whatsapp_number') }}" class="transition hover:text-white">Contact</a><a href="{{ route('tours.index') }}" wire:navigate class="rounded-full bg-lime px-5 py-2.5 font-semibold text-forest transition hover:bg-white">Book now</a></nav>
            <button type="button" class="grid size-10 place-items-center rounded-full border border-white/40 text-white md:hidden" @click="open = ! open" :aria-expanded="open" aria-label="Toggle menu"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="1.7" d="M4 7h16M4 12h16M4 17h16"/></svg></button>
        </div>
        <nav x-cloak x-show="open" x-transition class="mx-5 rounded-2xl bg-forest p-5 text-white shadow-2xl md:hidden"><div class="flex flex-col gap-4 text-lg"><a href="{{ route('home') }}">Home</a><a href="{{ route('tours.index') }}">Tours</a><a href="{{ route('home') }}#about">About</a><a href="{{ route('home') }}#gallery">Gallery</a><a href="https://wa.me/{{ config('tour.whatsapp_number') }}">WhatsApp</a></div></nav>
    </header>
    <main>{{ $slot }}</main>
    <footer class="bg-forest text-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 py-16 md:grid-cols-[1.4fr_1fr_1fr] lg:px-8"><div><div class="font-display text-2xl font-semibold">Penida Way</div><p class="mt-4 max-w-sm text-sm leading-7 text-white/60">Private island days, guided by people who call Nusa Penida home.</p></div><div><p class="text-xs font-semibold uppercase tracking-[.2em] text-lime">Explore</p><div class="mt-5 flex flex-col gap-3 text-sm text-white/70"><a href="{{ route('tours.index') }}">All tours</a><a href="{{ route('home') }}#about">Our approach</a><a href="{{ route('home') }}#gallery">Island gallery</a></div></div><div><p class="text-xs font-semibold uppercase tracking-[.2em] text-lime">Talk to a local</p><a href="https://wa.me/{{ config('tour.whatsapp_number') }}" class="mt-5 inline-flex border-b border-white/30 pb-1 text-sm">WhatsApp us ↗</a></div></div>
        <div class="mx-auto flex max-w-7xl justify-between border-t border-white/10 px-5 py-6 text-xs text-white/40 lg:px-8"><span>© {{ now()->year }} Penida Way</span><a href="{{ route('admin.login') }}">Admin</a></div>
    </footer>
    @livewireScripts
</body>
</html>
