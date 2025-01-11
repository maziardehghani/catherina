<?php

namespace App\Enums;

enum UserTypes: string
{
    case REAL = 'real';
    case LEGAL = 'legal';

    static function userTypes(): array
    {
        return [
            self::REAL,
            self::LEGAL,
        ];
    }
}
