<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfoTitle extends Model
{
    use HasFactory;

    protected $table = 'users_infos_titles';

    protected $fillable = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    public function scopeWhereTitle($query, $title)
    {
        return $query->firstWhere('title', $title);
    }
}
