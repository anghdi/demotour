<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'PENDING';
    case Confirmed = 'CONFIRMED';
    case Completed = 'COMPLETED';
    case Cancelled = 'CANCELLED';
}
