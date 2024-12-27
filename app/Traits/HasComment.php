<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComment
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
