<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_code', 'tour_id', 'travel_date', 'guest_count', 'customer_name',
        'customer_email', 'customer_whatsapp', 'customer_country', 'special_request',
        'subtotal', 'total', 'payment_method', 'payment_status', 'booking_status',
    ];

    /** @return BelongsTo<Tour, $this> */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /** @return Attribute<non-falsy-string, never> */
    protected function formattedTotal(): Attribute
    {
        return Attribute::get(fn (): string => 'Rp'.number_format((float) $this->total, 0, ',', '.'));
    }

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'payment_status' => PaymentStatus::class,
            'booking_status' => BookingStatus::class,
        ];
    }
}
