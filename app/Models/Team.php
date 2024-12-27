<?php

namespace App\Models;

use App\Traits\HasMedia;
use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    use HasFactory, HasStatus, HasSearch,HasMedia;
    protected $table = 'teams';

    protected $perPage= 20;

    protected $with = [
        'status',
        'user'
    ];

    protected $fillable = [
        'user_id',
        'position',
        'order',
        'instagram',
        'linkedin',
        'status_id'
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


    // ==============================================================================================================================================
    //
    //  Accessors
    //
    // ==============================================================================================================================================

    public function userName(): Attribute
    {
        return Attribute::make(function () {
            return $this->user?->userName;
        });
    }


    public function userAvatar(): Attribute
    {
        return Attribute::make(function () {
            return $this->user?->mediasUrl;
        });
    }

}
