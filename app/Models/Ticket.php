<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    use HasFactory, HasStatus, HasSearch;
    protected $table = 'tickets';

    protected $perPage= 20;

    protected $with = [
        'status',
        'user'
    ];

    protected $fillable = [
        'user_id',
        'category',
        'subject',
        'content',
        'parent_id',
        'status_id'
    ];

    protected $appends = [
        'userName',
        'statusTitle',
    ];


    public static array $translations=[
        'management' => 'مدیریت',
        'financial' => 'مالی',
        'backup' => 'پشتیبانی',
    ];

    // ==============================================================================================================================================
    //
    //  Relations
    //
    // ==============================================================================================================================================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'parent_id');
    }


    public function child(): HasMany
    {
        return $this->hasMany(Ticket::class, 'parent_id');
    }

    // ==============================================================================================================================================
    //
    //  Accessors
    //
    // ==============================================================================================================================================
    public function userName():Attribute
    {
        return Attribute::make(
            get: fn() => $this->user?->username
        );
    }

    public function userAvatar():Attribute
    {
        return Attribute::make(
            get: fn() => $this->user?->mediasUrl
        );
    }

    public function answer():Attribute
    {
        return Attribute::make(
            get: fn() => $this->parent?->content
        );
    }
    public function persianCategory():Attribute
    {
        return Attribute::make(
            get: fn() => self::$translations[$this->category]
        );
    }
}
