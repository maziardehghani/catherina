<?php

namespace App\Models;

use App\Enums\Statuses;
use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, HasStatus, SoftDeletes, HasSearch;

    protected $table = 'transactions';

    protected $fillable = [
        'order_id',
        'amount',
        'status_id',
        'terminal_id',
        'trace_number',
        'rrn',
        'secure_pan',
        'token',
        'gateWay',
        'created_at',
    ];

    protected $perPage = 20;

    public static array $persianGateways = [
        'online' => 'درگاه',
        'receipt' => 'فیش'
    ];


    // ==================================================================================
    //
    //  Relations
    //
    // ==================================================================================


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Order::class,
            'id',
            'id',
            'order_id',
            'user_id'
        );
    }

    public function project(): HasOneThrough
    {
        return $this->hasOneThrough(
            Project::class,           // Final target model (User)
            Order::class,          // Intermediate model (Order)
            'id',                  // Foreign key on the 'orders' table (connects to 'items.order_id')
            'id',                  // Foreign key on the 'users' table (User's primary key)
            'order_id',            // Foreign key on the 'items' table (links to Order)
            'orderable_id'              // Foreign key on the 'orders' table (links to User)
        )->where('orderable_type', Project::class); // Add polymorphic condition
    }
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }


    // ==================================================================================
    //
    //  Scopes
    //
    // ==================================================================================

    public function scopeWhereUserId($query, $userId)
    {
        return $query->whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function scopeWhereProjectId($query, $projectId)
    {
        return $query->whereHas('order.orderable', function ($query) use ($projectId) {
            $query->where('id', $projectId);
        });
    }


    public function scopeFilterByProject($query, $projectId)
    {
        return $query->when($projectId, function ($query) use ($projectId) {
            $query->whereHas('order.orderable', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            });
        });
    }

    // ==================================================================================
    //
    //  Accessors
    //
    // ==================================================================================

    public function persianGateway(): Attribute
    {
        return Attribute::make(fn() => self::$persianGateways[$this->gateWay]);
    }

    public function persianStatus(): Attribute
    {
        return Attribute::make(fn() => $this->status?->persianTitle);
    }

    public function userName(): Attribute
    {
        return Attribute::make(fn() => $this->user?->userName);
    }

    public function projectTitle(): Attribute
    {
        return Attribute::make(fn() => $this->project?->shortTitle);
    }

}
