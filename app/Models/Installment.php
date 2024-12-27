<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use HasFactory, SoftDeletes, HasStatus, HasSearch;

    protected $table = 'installments';

    protected $fillable = [
        'invoice_id',
        'amount',
        'status_id',
        'description',
        'due_date',
        'payment_date',
    ];

    protected $with = [
        'status',
        'invoice'
    ];


    // ==================================================================================
    //
    //  Relations
    //
    // ==================================================================================


    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    // ==================================================================================
    //
    //  Scopes
    //
    // ==================================================================================


    public function scopeWhereUserId($query, $userId)
    {
        return $query->whereHas('invoice.transaction.order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query = $query->whereHas('invoice.transaction.user', function ($query) use ($search) {
                $query->whereRaw("CONCAT(name, ' ', family) LIKE ?", ["%{$search}%"])
                    ->orWhere('mobile', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });

            return $query->orWhereHas('invoice.transaction.user.userInfos', function ($query) use ($search) {
                $query->where('value', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeFilterByProject($query, $projectId)
    {
        return $query->when($projectId, function ($query) use ($projectId) {
            $query->whereHas('invoice.transaction.order.orderable', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            });
        });
    }


    protected function scopeWhereRegisterAt($query, $date)
    {
        return $query->when($date, function ($query) use ($date) {
            $startDate = Verta::parse($date)->startDay()->toCarbon();
            $endDate = Verta::parse($date)->endDay()->toCarbon();

            return $query->whereBetween('due_date', [$startDate, $endDate]);
        });
    }


    // ==================================================================================
    //
    //  Accessors
    //
    // ==================================================================================


    public function userName(): Attribute
    {
        return Attribute::make(fn () => $this->invoice?->transaction?->order?->user?->userName );
    }

    public function projectTitle(): Attribute
    {
        return Attribute::make(fn () => $this->invoice?->transaction?->project?->shortTitle );
    }

}
