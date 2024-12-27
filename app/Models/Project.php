<?php

namespace App\Models;

use App\Enums\Statuses;
use App\Interfaces\Mediaable;
use App\Interfaces\Slugable;
use App\Traits\HasComment;
use App\Traits\HasManyMedias;
use App\Traits\HasSearch;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Project extends Model implements Mediaable, Slugable
{

    use HasFactory, HasSearch, HasStatus, HasManyMedias, SoftDeletes, HasComment, HasSlug;

    protected $table = 'projects';

    protected $perPage = 10;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'city_id',
        'percent',
        'funding_period',
        'project_intro',
        'expert_opinion',
        'company_intro',
        'project_risks',
        'warranty_inquiry_id',
        'warranty_details',
        'participation_generated',
        'status_id',
        'stopped_at',
    ];

    protected $attributes = [
        'status_id' => 6
    ];

    // ==================================================================================
    //
    //  Relations
    //
    // ==================================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectStatusLogs(): HasMany
    {
        return $this->hasMany(ProjectStatusLog::class, 'project_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function warranty(): BelongsTo
    {
        return $this->belongsTo(Warranty::class, 'warranty_inquiry_id');
    }

    public function farabourse(): HasOne
    {
        return $this->hasOne(FarabourseProject::class, 'project_id');
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function state(): HasOneThrough
    {
        return $this->hasOneThrough(State::class, City::class, 'id', 'id', 'city_id', 'state_id');
    }

    public function experts(): HasMany
    {
        return $this->hasMany(ProjectUserExpert::class, 'project_id');
    }

    // ==================================================================================
    //
    //  Scopes
    //
    // ==================================================================================
    public function scopeWhereOrderUserId($query, $userId)
    {
        return $query->whereHas('orders', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function scopeWhereOrderUserPaid($query, $userId)
    {
        return $query->whereHas('orders', function ($query) use ($userId) {
            $query->where('user_id', $userId)->whereHas('transaction', function ($query) {
                $query->whereStatusTitle(Statuses::PAID);
            });
        });
    }

    // ==================================================================================
    //
    //  Accessors
    //
    // ==================================================================================
    public function getInstallments()
    {
        return $this->orders?->transaction?->invoice?->installments;
    }

    public function cityStateName(): Attribute
    {
        return Attribute::make(get: fn() => $this->state?->name);
    }

    public function farabourseTotalAmounts(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->total_amounts ?? 0 );
    }

    public function minimumAmount(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->minimum_require_price ?? 0 );
    }

    public function cityName(): Attribute
    {
        return Attribute::make(get: fn() => $this->city?->name);
    }

    public function warrantyTitle(): Attribute
    {
        return Attribute::make(get: fn() => $this->warranty?->title);
    }

    public function warrantyId(): Attribute
    {
        return Attribute::make(get: fn() => $this->warranty?->id);
    }


    public function warrantyLink(): Attribute
    {
        return Attribute::make(get: fn() => $this->warranty?->link);
    }

    public function persianStatus(): Attribute
    {
        return Attribute::make(get: fn() => Status::$persianStatuses[$this->statusTitle] ?? null);
    }

    public function logo(): Attribute
    {
        return Attribute::make(get: fn() => $this->medias()->whereType('logo')->first()?->url);
    }

    public function banner(): Attribute
    {
        return Attribute::make(get: fn() => $this->medias()->whereType('banner')->first()?->url);
    }

    public function shortTitle(): Attribute
    {
        return Attribute::make(get: fn() => Str::substr($this->title, -30));
    }

    public function collectedAmount(): Attribute
    {
        return Attribute::make(get: function () {
            return Transaction::query()
                ->whereStatusTitle(Statuses::PAID)
                ->whereHas('invoice')
                ->whereProjectId($this->id)
                ->sum('amount');
        });
    }

    public function realPersonMinimAmount(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->real_person_minimum_available_price ?? 0) ;
    }

    public function legalPersonMinimAmount(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->legal_person_minimum_available_price ?? 0);
    }

    public function realPersonMaximAmount(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->real_person_maximum_available_price ?? 0);
    }

    public function legalPersonMaximAmount(): Attribute
    {
        return Attribute::make(get: fn() => $this->farabourse?->legal_person_maximum_available_price ?? 0);
    }

}
