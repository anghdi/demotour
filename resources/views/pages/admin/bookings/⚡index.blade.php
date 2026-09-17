<?php

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $status = 'ALL';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }
    public function with(): array
    {
        $bookings = Booking::query()->with('tour')->when($this->search, fn ($query) => $query->where(fn ($nested) => $nested->where('booking_code', 'like', '%'.$this->search.'%')->orWhere('customer_name', 'like', '%'.$this->search.'%')))->when($this->status !== 'ALL', fn ($query) => $query->where('booking_status', $this->status))->latest()->paginate(10);
        return ['bookings' => $bookings];
    }
};
?>

<div><header><p class="text-xs font-semibold uppercase tracking-[.18em] text-leaf">Operations</p><h1 class="mt-2 font-display text-3xl font-semibold tracking-[-.04em]">Bookings</h1></header><div class="mt-8 flex flex-col gap-3 sm:flex-row"><input type="search" wire:model.live.debounce.300ms="search" placeholder="Search ID or customer…" class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 outline-none focus:border-leaf sm:max-w-sm"><select wire:model.live="status" class="rounded-xl border border-ink/10 bg-white px-4 py-3 outline-none"><option value="ALL">All statuses</option><option value="PENDING">Pending</option><option value="CONFIRMED">Confirmed</option><option value="COMPLETED">Completed</option><option value="CANCELLED">Cancelled</option></select></div><div class="mt-6 overflow-x-auto rounded-2xl bg-white"><table class="w-full min-w-[780px] text-left text-sm"><thead class="border-b border-ink/10 text-xs uppercase tracking-[.12em] text-ink/40"><tr><th class="p-5">Booking</th><th>Customer</th><th>Tour</th><th>Date</th><th>Total</th><th>Status</th></tr></thead><tbody>@forelse ($bookings as $booking)<tr wire:key="booking-{{ $booking->id }}" class="border-b border-ink/5 last:border-0"><td class="p-5 font-semibold"><a href="{{ route('admin.bookings.show', $booking) }}" wire:navigate class="hover:text-leaf">{{ $booking->booking_code }}</a></td><td><p>{{ $booking->customer_name }}</p><p class="text-xs text-ink/40">{{ $booking->customer_email }}</p></td><td>{{ $booking->tour->name }}</td><td>{{ $booking->travel_date->format('d M Y') }}</td><td>{{ $booking->formatted_total }}</td><td><span class="rounded-full bg-lime/50 px-3 py-1 text-xs font-semibold">{{ $booking->booking_status->value }}</span></td></tr>@empty<tr><td colspan="6" class="p-10 text-center text-ink/40">No matching bookings.</td></tr>@endforelse</tbody></table></div><div class="mt-6">{{ $bookings->links() }}</div></div>
