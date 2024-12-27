<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUserExpert extends Model
{
    use HasFactory;

    protected $table = 'projects_user_experts';

    protected $perPage = 10;

    protected $with = [
        'user'
    ];

    protected $fillable = [
        'user_id',
        'project_id',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function mediasUrl(): Attribute
    {
        return Attribute::make(function () {
            return $this->user?->mediasUrl;
        });
    }


    public function userName(): Attribute
    {
        return Attribute::make(function () {
            return $this->user?->userName;
        });
    }
}
