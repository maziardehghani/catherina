<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory, HasStatus, HasSearch;

    protected $with = [
        'status',
    ];

    protected $perPage = 20;

    protected $fillable = [
        'user_id',
        'project_id',
        'commentable_type',
        'commentable_id',
        'parent_id',
        'content',
        'status_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            return $query->whereHas('user', function ($query) use ($search) {
                $query->whereRaw("CONCAT(name, ' ', family) LIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('mobile', 'LIKE', "%$search%")
                    ->orWhereHas('userInfos', function ($query) use ($search) {
                        return $query->where('value', 'LIKE', "%$search%");
                    });
            });
        });
    }


    protected function scopeFilterByProject($query, $projectId)
    {
        return $query->when($projectId, function ($query) use ($projectId) {
           $query->whereHas('commentable', function ($query) use ($projectId) {
               $query->where('id' , $projectId);
           });
        });
    }

    protected function scopeFilterByArticle($query, $articleId)
    {
        return $query->when($articleId, function ($query) use ($articleId) {
           $query->whereHas('commentable', function ($query) use ($articleId) {
               $query->where('id' , $articleId);
           });
        });
    }

    public function parent():BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
