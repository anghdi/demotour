<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.auth')] class extends Component
{
    public string $email = '';
    public string $password = '';

    public function login(): mixed
    {
        $this->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        if (! hash_equals((string) config('tour.admin_email'), $this->email) || ! hash_equals((string) config('tour.admin_password'), $this->password)) {
            $this->addError('email', 'These demo credentials do not match.');
            return null;
        }
        session()->regenerate();
        session(['admin_authenticated' => true]);
        return $this->redirectRoute('admin.dashboard', navigate: true);
    }
};
?>

<div class="grid min-h-screen lg:grid-cols-2"><div class="relative hidden overflow-hidden lg:block"><img src="https://images.unsplash.com/photo-1573790387438-4da905039392?auto=format&fit=crop&w=1400&q=90" alt="Nusa Penida" class="h-full w-full object-cover"><div class="absolute inset-0 bg-forest/30"></div><p class="absolute bottom-10 left-10 max-w-md font-display text-4xl font-semibold leading-tight text-white">Every memorable island day starts behind this desk.</p></div><div class="flex items-center justify-center px-5 py-16"><form wire:submit="login" class="w-full max-w-sm rounded-2xl bg-sand p-7 md:p-9"><a href="{{ route('home') }}" class="font-display text-xl font-semibold">Penida Way <span class="text-leaf">/</span></a><p class="mt-2 text-sm text-ink/50">Admin access for the demo workspace.</p><div class="mt-8 space-y-5"><div><label for="email" class="text-sm font-semibold">Email</label><input id="email" type="email" wire:model="email" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf"></div><div><label for="password" class="text-sm font-semibold">Password</label><input id="password" type="password" wire:model="password" class="mt-2 w-full rounded-xl border border-ink/15 bg-white px-4 py-3.5 outline-none focus:border-leaf"></div>@error('email')<p class="text-sm text-clay">{{ $message }}</p>@enderror</div><button class="mt-7 w-full rounded-full bg-forest px-6 py-4 font-semibold text-white">Sign in</button><div class="mt-6 rounded-xl bg-lime/45 p-4 text-xs leading-5 text-forest"><strong>Demo:</strong> {{ config('tour.admin_email') }} / {{ config('tour.admin_password') }}</div></form></div></div>
