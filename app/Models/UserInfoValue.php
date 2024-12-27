<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserInfoValue extends Model
{
    use HasFactory;

    protected $table = 'users_infos_values';

    protected $fillable = [
        'id',
        'user_id',
        'user_info_title_id',
        'value',
        'created_at',
        'updated_at',
    ];


    public function userInfoTitle(): BelongsTo
    {
        return $this->belongsTo(UserInfoTitle::class, 'user_info_title_id');
    }

    public function scopeWhereTitle($query, $title)
    {
        return $query->whereHas('userInfoTitle', function ($query) use ($title) {
            return $query->where('title', $title);
        });
    }

    public function scopeWhereValue($query, $value)
    {
        return $query->where('value', $value);
    }

    public function scopeWhereNotUserId($query, $userId)
    {
        return $query->when($userId, function ($query) use ($userId) {
             $query->where('user_id', '!=' , $userId);
        });
    }
}
