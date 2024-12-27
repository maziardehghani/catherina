<?php

namespace App\Repositories\Invoice;

use App\Models\Invoice;
use App\Models\Project;
use App\Repositories\Repository;
use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;

class InvoiceRepository extends Repository
{
    public function __construct()
    {
        $this->model = Invoice::query();
        $this->paginate = 10;
    }

    public function store($data): object
    {
        return Invoice::query()->create([
            'transaction_id' => $data['transaction_id'],
            'trace_code' => null,
            'term_conditions_accepted' => true,
            'created_at' => CalendarService::gregorianDate($data['date']),
        ]);
    }

    public function update($model, array|object $data): bool
    {
        return $model->update([
            'transaction_id' => $data['transaction_id'],
            'trace_code' => null,
            'term_conditions_accepted' => true,
            'created_at' => CalendarService::gregorianDate($data['date']),
        ]);
    }

    public function delete($model): bool
    {
        return $model->transaction?->order()?->delete() &&
            $model->transaction()?->delete() &&
            $model->delete();
    }

    public function getInvoicesOfUser($user)
    {
        return $this->model
            ->whereUserId($user->id)
            ->with('transaction.order')
            ->latest()
            ->paginate($this->paginate);
    }
}
