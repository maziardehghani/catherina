<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\Project;
use App\Repositories\Repository;
use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;

class OrderRepository extends Repository
{
    public function __construct()
    {
        $this->model = Order::query();
    }

    public function store($data): object
    {
        return $this->model->create([
            'orderable_type' => Project::class,
            'orderable_id' => $data['project_id'],
            'user_id' => $data['user_id'],
            'created_at' => CalendarService::gregorianDate($data['date']) ,
        ]);
    }

    public function update($model,$data): bool
    {
        return $model->update([
            'orderable_type' => Project::class,
            'orderable_id' => $data['project_id'],
            'user_id' => $data['user_id'],
            'created_at' => CalendarService::gregorianDate($data['date']) ,
        ]);
    }

}
