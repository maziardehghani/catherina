<?php

namespace App\Models;

use App\Interfaces\Mediaable;
use App\Traits\HasMedia;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model implements Mediaable
{
    use HasFactory, HasSearch, HasMedia, SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'trace_code',
        'term_conditions_accepted',
        'created_at',
    ];

    protected $perPage = 20;

    // ==============================================================================================================================================
    //
    //  Relations
    //
    // ==============================================================================================================================================

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'invoice_id');
    }


    // ==============================================================================================================================================
    //
    //  Scopes
    //
    // ==============================================================================================================================================

    public function scopeWhereUserId($query, $userId)
    {
        return $query->whereHas('transaction.order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query = $query->whereHas('transaction.user', function ($query) use ($search) {
                $query->whereRaw("CONCAT(name, ' ', family) LIKE ?", ["%{$search}%"])
                    ->orWhere('mobile', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });

            return $query->orWhereHas('transaction.user.userInfos', function ($query) use ($search) {
                $query->where('value', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeFilterByProject($query, $projectId)
    {
        return $query->when($projectId, function ($query) use ($projectId) {
            $query->whereHas('transaction.order.orderable', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            });
        });
    }

    // ==============================================================================================================================================
    //
    //  Accessors
    //
    // ==============================================================================================================================================


    public function userName(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->order?->user?->userName );
    }

    public function amount(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->amount);
    }

    public function userPersianType(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->order?->user?->persianType);
    }

    public function persianGateWay(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->persianGateWay);
    }

    public function gateWay(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->gateWay);
    }

    public function traceNumber(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->trace_number);
    }

    public function StatusId(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->status_id);
    }

    public function persianStatus(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->persianStatus);
    }

    public function projectName(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->order?->projectName);
    }

    public function userMobile(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->order?->user?->mobile);
    }

    public function terminalId(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->terminal_id);
    }

    public function securePan(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->secure_pan);
    }

    public function rrn(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->rrn);
    }

    public function getShebaExceptAyandehBank(): Attribute
    {
        return Attribute::make(fn () =>
        $this->transaction?->order?->user?->bankName !== 'بانک آینده'
            ? $this->transaction?->order?->user?->sheba
            : $this->transaction?->order?->user?->account_number
        );
    }

    public function token(): Attribute
    {
        return Attribute::make(fn () => $this->transaction?->token);
    }

    public function receiptImage(): Attribute
    {
        return Attribute::make(fn () => $this->medias()->whereType('receipt')->first()?->url);
    }

    public function userNationalId(): Attribute
    {
        return Attribute::make(fn () =>
        $this->transaction?->order?->user
            ?->type === 'real'
            ? $this->transaction?->order?->user?->nationalId
            : ($this->transaction?->order?->user?->type === 'legal'
            ? $this->transaction?->order?->user?->registerCode
            : null)
        );
    }




}
