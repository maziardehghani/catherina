<?php

namespace App\Models;

use App\Interfaces\Mediaable;
use App\Traits\HasComment;
use App\Traits\HasMedia;
use App\Traits\HasSearch;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Article extends Model implements Mediaable
{
    use HasFactory, HasMedia, HasSearch, HasStatus, HasComment, HasSlug;

    protected $table = 'articles';

    protected $perPage= 20;

    protected $fillable = [
        'title',
        'user_id',
        'slug',
        'content',
        'intro',
        'status_id'
    ];

    protected $with = [
        'status',
        'medias',
        'user'
    ];

    // ==============================================================================================================================================
    //
    //  Relations
    //
    // ==============================================================================================================================================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // ==============================================================================================================================================
    //
    //  Accessors
    //
    // ==============================================================================================================================================
    public function writer() :Attribute
    {
        return Attribute::make(function ()
        {
            return $this->user?->name . ' ' . $this->user?->family;
        });
    }

    public function writerAvatar() :Attribute
    {
        return Attribute::make(function ()
        {
            return $this->user?->mediasUrl;
        });
    }

    public function commentCounts() :Attribute
    {
        return Attribute::make(function ()
        {
            return $this->comments()->count();
        });
    }

    public function shortTitle(): Attribute
    {
        return Attribute::make(get: fn() => Str::substr($this->title, -30));
    }


    public function mediasUrl(): Attribute
    {
        return Attribute::make(function () {
            return $this->medias?->url;
        });
    }
}
