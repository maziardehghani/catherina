<?php

namespace App\Traits;
use App\Models\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasStatus
{
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeWhereStatusTitle($query, $statusTitle)
    {
        return $query->whereHas('status', function ($query) use ($statusTitle) {
            $query->where('title', $statusTitle);
        });
    }

    public function statusTitle():Attribute
    {
        return Attribute::make(function (){
            return $this->status?->title;
        });
    }

    public function persianStatus():Attribute
    {
        return Attribute::make(get: fn() => Status::$persianStatuses[$this->statusTitle] ?? null);
    }
}
