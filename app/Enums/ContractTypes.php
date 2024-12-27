<?php

namespace App\Enums;

use function Laravel\Prompts\search;

enum ContractTypes: string
{
    case INVESTOR_REPRESENTATION_CONTRACT = 'investor_representation_contract';
    case INVESTOR_CONTRACT = 'investor_contract';
    case BROKE_CONTRACT = 'broke_contract';
    case FINANCIAL_PARTNERSHIP_CONTRACT = 'financial_partnership_contract';
    case THREE_SESSION_PROJECT_CONTRACT = 'three_session_project_contract';
    case PERIODIC_REPORT = 'periodic_report';
    case SPECIAL_REPORT = 'special_report';

    public static function contracts(): array
    {
        return [
            self::INVESTOR_CONTRACT->value,
            self::BROKE_CONTRACT->value,
            self::FINANCIAL_PARTNERSHIP_CONTRACT->value,
            self::THREE_SESSION_PROJECT_CONTRACT->value,
            self::PERIODIC_REPORT->value,
            self::SPECIAL_REPORT->value,
        ];
    }
}
