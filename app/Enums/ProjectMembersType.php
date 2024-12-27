<?php

namespace App\Enums;

enum ProjectMembersType:string
{
    case SHAREHOLDER = 'shareholder';
    case STAKMEMBER = 'stakmember';

    public static function types()
    {
        return [
            self::SHAREHOLDER->value,
            self::STAKMEMBER->value,
        ];
    }

}
