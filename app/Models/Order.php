<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'orderable_type',
        'orderable_id',
        'user_id',
        'created_at',
    ];

    protected $with = [
        'orderable'
    ];

    // ==============================================================================================================================================
    //
    //  Relations
    //
    // ==============================================================================================================================================

    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'order_id');
    }

    public function projectName():Attribute
    {
        return  Attribute::make(function (){
            return $this->orderable->title;
        });
    }

    public function projectTraceCode():Attribute
    {
        return  Attribute::make(function (){
            return $this->orderable?->farabourse?->trace_code;
        });
    }

    public function projectProfitPercent():Attribute
    {
        return  Attribute::make(function (){
            return $this->orderable?->farabourse?->trace_code;
        });
    }

}
