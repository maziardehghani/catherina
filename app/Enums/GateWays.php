<?php

namespace App\Enums;

enum GateWays: string
{
    case PAID = 'paid';

    case CANCELLED = 'cancelled';

    case REFUNDED = 'refunded';
}
