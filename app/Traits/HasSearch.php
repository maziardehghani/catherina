<?php

namespace App\Traits;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

trait HasSearch
{
    protected function scopeSearch($query, $search, array $columns)
    {
        return $query->when($search, function ($query) use ($search, $columns) {
            return $this->whereColumn($query, $columns, $search);
        });
    }

    protected function whereColumn($query, array $columns, $search)
    {
        return $query->when($search, function () use ($columns, $query, $search) {
            collect($columns)->map(function ($column) use ($query, $search) {
                return $query->orWhere($column, 'LIKE', "%$search%");
            });
        });
    }

    protected function scopeWhereTitle($query, $title)
    {
        return $query->where('title', 'LIKE', "%$title%");
    }

    protected function scopeWhereStatus($query, $status)
    {
        return $query->when($status, function ($query) use ($status) {
            return $query->where('status_id', $status);
        });
    }

    protected function scopeWhereType($query, $type)
    {
        return $query->when($type, function ($query) use ($type) {
            return $query->where('type', $type);
        });
    }

    protected function scopeWhereRegisterAt($query, $date)
    {
        return $query->when($date, function ($query) use ($date) {
            $startDate = Verta::parse($date)->startDay()->toCarbon();
            $endDate = Verta::parse($date)->endDay()->toCarbon();

            return $query->whereBetween('created_at', [$startDate, $endDate]);
        });
    }
}
