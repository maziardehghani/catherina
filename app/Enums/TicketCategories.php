<?php

namespace App\Enums;

enum TicketCategories: string
{
    case MANAGEMENT = 'management';
    case FINANCIAL = 'financial';
    case BACKUP = 'backup';

    public static function categories(): array
    {
        return [
            self::MANAGEMENT->value,
            self::FINANCIAL->value,
            self::BACKUP->value,
        ];
    }
}
