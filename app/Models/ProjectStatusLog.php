<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectStatusLog extends Model
{
    use HasFactory, HasStatus;

    protected $table = 'project_status_logs';

    protected $fillable = [
        'project_id',
        'status_id',
        'user_id'
    ];

    protected $with = [
        'status',
        'project'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userName(): Attribute
    {
        return Attribute::make(get: fn() => $this->user?->userName ?? 'سیستم خودکار');
    }

}
