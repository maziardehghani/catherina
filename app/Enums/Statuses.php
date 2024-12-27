<?php

namespace App\Enums;

enum Statuses: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ANSWERED = 'answered';
    case PENDING = 'pending';
    case CLOSED = 'closed';
    case UNKNOWN = 'unknown';
    case AWAITING_AGENT_APPROVAL = 'awaiting_agent_approval';
    case AWAITING_FINANCIAL_APPROVAL = 'awaiting_financial_approval';
    case AWAITING_SYMBOLIC_APPROVAL = 'awaiting_symbol_approval';
    case REJECTION_PLAN = 'rejection_plan';
    case START_FUNDRAISING = 'start_fundraising';
    case FUNDRAISING_SUCCEED = 'fundraising_succeed';
    case CLEARED = 'cleared';
    case FUNDRAISING_FAILED = 'fundraising_failed';
    case RETURNED = 'returned';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';
    case PAID = 'paid';
    case STOPPED = 'stopped';


    /**
     * @return Statuses[]
     *
     * these func return all statuses
     */
    static function statuses(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
            self::ANSWERED->value,
            self::CLOSED->value,
            self::PENDING->value,
            self::UNKNOWN->value,
            self::AWAITING_AGENT_APPROVAL->value,
            self::AWAITING_FINANCIAL_APPROVAL->value,
            self::AWAITING_SYMBOLIC_APPROVAL->value,
            self::REJECTION_PLAN->value,
            self::START_FUNDRAISING->value,
            self::FUNDRAISING_SUCCEED->value,
            self::CLEARED->value,
            self::FUNDRAISING_FAILED->value,
            self::RETURNED->value,
            self::CANCELLED->value,
            self::REJECTED->value,
            self::PAID->value,
            self::STOPPED->value
        ];
    }

    /**
     * @return Statuses[]
     *
     * these statuses can be used for every models
     */
    static function commonStatuses(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
        ];
    }

    static function TicketStatuses(): array
    {
        return [
            self::ANSWERED->value,
            self::CLOSED->value,
            self::PENDING->value
        ];
    }

    static function ProjectStatuses(): array
    {
        return [
            self::UNKNOWN->value,
            self::AWAITING_AGENT_APPROVAL->value,
            self::AWAITING_FINANCIAL_APPROVAL->value,
            self::AWAITING_SYMBOLIC_APPROVAL->value,
            self::REJECTION_PLAN->value,
            self::START_FUNDRAISING->value,
            self::FUNDRAISING_SUCCEED->value,
            self::CLEARED->value,
            self::FUNDRAISING_FAILED->value,
        ];
    }


    static function TransactionStatuses(): array
    {
        return [
            self::RETURNED->value,
            self::CANCELLED->value,
            self::REJECTED->value,
            self::PAID->value,
            self::PENDING->value,
        ];
    }

    static function installmentStatuses()
    {
        return [
            self::PAID->value,
            self::PENDING->value,
            self::STOPPED->value,
        ];
    }
}
