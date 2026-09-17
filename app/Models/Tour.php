<?php

namespace App\Models;

use Database\Factories\TourFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    /** @use HasFactory<TourFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'eyebrow', 'description', 'price', 'duration', 'tour_type',
        'image', 'gallery', 'destinations', 'included', 'excluded', 'active',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** @return HasMany<Booking, $this> */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /** @return Attribute<non-falsy-string, never> */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn (): string => 'Rp'.number_format((float) $this->price, 0, ',', '.'));
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'gallery' => 'array',
            'destinations' => 'array',
            'included' => 'array',
            'excluded' => 'array',
            'active' => 'boolean',
        ];
    }
}
