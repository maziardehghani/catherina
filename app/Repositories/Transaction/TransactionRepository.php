<?php

namespace App\Repositories\Transaction;

use App\Enums\Statuses;
use App\Models\Transaction;
use App\Repositories\Repository;
use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;

class TransactionRepository extends Repository
{
    public function __construct()
    {
        $this->model = Transaction::query();
        $this->paginate = 20;
    }

    public function store($data): object
    {
        return $this->model->create([
            'order_id' => $data['order_id'],
            'amount' => $data['amount'],
            'status_id' => $data['status_id'],
            'terminal_id' => null,
            'trace_number' => $data['trace_number'],
            'rrn' => null,
            'secure_pan' => null,
            'token' => null,
            'gateWay' => 'receipt',
            'created_at' => CalendarService::gregorianDate($data['date']),
        ]);
    }

    public function update($model, $data):bool
    {
        return $model->update([
            'order_id' => $data['order_id'],
            'amount' => $data['amount'],
            'status_id' => $data['status_id'],
            'terminal_id' => null,
            'trace_number' => $data['trace_number'],
            'rrn' => null,
            'secure_pan' => null,
            'token' => null,
            'gateWay' => 'receipt',
            'created_at' => CalendarService::gregorianDate($data['date']),
        ]);
    }

    public function getSumInvoicesOfUser($user):int
    {
        return $this->model
            ->whereStatusTitle(Statuses::PAID)
            ->whereUserId($user->id)
            ->sum('amount');
    }
}
