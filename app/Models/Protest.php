<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Protest extends Model
{
    use HasFactory;

    protected $table = 'protests';

    protected $with = [
        'user'
    ];

    protected $fillable = [
        'user_id',
        'project_id',
        'content'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
