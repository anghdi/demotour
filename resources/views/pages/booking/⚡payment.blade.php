<?php

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public Tour $tour;
    public array $draft = [];
    public array $customer = [];
    public string $paymentMethod = 'CARD';

    public function mount(): void
    {
        $this->draft = session('booking.draft', []);
        $this->customer = session('booking.customer', []);
        abort_unless(isset($this->draft['tour_id'], $this->customer['customer_email']), 404);
        $this->tour = Tour::query()->findOrFail($this->draft['tour_id']);
    }

    public function pay(): mixed
    {
        $this->validate(['paymentMethod' => ['required', 'in:CARD,BANK_TRANSFER,QRIS']]);
        $booking = DB::transaction(function (): Booking {
            $total = (int) $this->tour->price * $this->draft['guest_count'];
            $booking = Booking::query()->create([...$this->customer, 'tour_id' => $this->tour->id, 'travel_date' => $this->draft['travel_date'], 'guest_count' => $this->draft['guest_count'], 'subtotal' => $total, 'total' => $total, 'payment_method' => $this->paymentMethod, 'payment_status' => PaymentStatus::Paid, 'booking_status' => BookingStatus::Pending]);
            $booking->update(['booking_code' => 'NP-'.now()->format('Ymd').'-'.str_pad((string) $booking->id, 3, '0', STR_PAD_LEFT)]);

            return $booking;
        });
        session()->forget(['booking.draft', 'booking.customer']);
        session(['booking.completed_id' => $booking->id]);

        return $this->redirectRoute('booking.success', navigate: true);
    }
};
?>

<div><section class="bg-forest px-5 pb-12 pt-32 text-white"><div class="mx-auto max-w-4xl"><p class="text-xs font-semibold uppercase tracking-[.2em] text-lime">Booking · Step 3 of 3</p><h1 class="mt-4 font-display text-4xl font-semibold tracking-[-.045em]">Complete your booking.</h1></div></section><section class="mx-auto grid max-w-4xl gap-10 px-5 py-14 md:grid-cols-[1fr_300px]"><form wire:submit="pay" class="rounded-2xl bg-white p-6 md:p-8" x-data><h2 class="font-display text-xl font-semibold">Payment method</h2><div class="mt-6 grid gap-3">@foreach (['CARD' => 'Credit / Debit Card', 'BANK_TRANSFER' => 'Bank Transfer', 'QRIS' => 'QRIS'] as $value => $label)<label wire:key="method-{{ $value }}" class="flex cursor-pointer items-center gap-3 rounded-xl border p-4 transition {{ $paymentMethod === $value ? 'border-leaf bg-leaf/5' : 'border-ink/10' }}"><input type="radio" wire:model.live="paymentMethod" value="{{ $value }}" class="accent-[#2d6a4f]"><span class="text-sm font-semibold">{{ $label }}</span></label>@endforeach</div>@if ($paymentMethod === 'CARD')<div class="mt-6 grid gap-4" wire:key="card-fields"><input type="text" inputmode="numeric" autocomplete="off" placeholder="Card number (demo only)" class="rounded-xl border border-ink/15 px-4 py-3.5 outline-none focus:border-leaf"><div class="grid grid-cols-2 gap-4"><input type="text" autocomplete="off" placeholder="MM / YY" class="rounded-xl border border-ink/15 px-4 py-3.5 outline-none focus:border-leaf"><input type="password" autocomplete="off" placeholder="CVV" class="rounded-xl border border-ink/15 px-4 py-3.5 outline-none focus:border-leaf"></div><p class="text-xs leading-5 text-ink/45">Demo fields only. Card details are never sent to the server or stored.</p></div>@else<div class="mt-6 rounded-xl bg-sand p-5 text-sm leading-6 text-ink/60">This is a payment simulation. Click below to mark the booking as paid.</div>@endif<button type="submit" class="mt-7 w-full rounded-full bg-forest px-6 py-4 font-semibold text-white hover:bg-leaf" wire:loading.attr="disabled"><span wire:loading.remove>Pay Rp{{ number_format((float) $tour->price * $draft['guest_count'], 0, ',', '.') }}</span><span wire:loading>Processing payment…</span></button></form><aside class="h-fit rounded-2xl border border-ink/10 p-6"><p class="text-xs font-semibold uppercase tracking-[.16em] text-leaf">Your booking</p><h3 class="mt-3 font-display text-xl font-semibold">{{ $tour->name }}</h3><dl class="mt-6 space-y-3 text-sm"><div class="flex justify-between"><dt class="text-ink/45">Date</dt><dd>{{ \Illuminate\Support\Carbon::parse($draft['travel_date'])->format('d M Y') }}</dd></div><div class="flex justify-between"><dt class="text-ink/45">Guests</dt><dd>{{ $draft['guest_count'] }}</dd></div><div class="flex justify-between border-t border-ink/10 pt-4 font-semibold"><dt>Total</dt><dd>Rp{{ number_format((float) $tour->price * $draft['guest_count'], 0, ',', '.') }}</dd></div></dl></aside></section></div>
