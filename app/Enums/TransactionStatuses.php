<?php

namespace App\Enums;

enum TransactionStatuses: string
{
    case PAID = 'paid';

    case CANCELLED = 'cancelled';

    case REFUNDED = 'refunded';
}
