<?php

namespace App\Models;

use App\Interfaces\Mediaable;
use App\Traits\HasMedia;
use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model implements Mediaable
{
    use HasFactory, SoftDeletes, HasSearch, HasStatus, HasMedia;

    protected $table = 'contracts';

    protected $perPage = 20;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'type',
        'document_type',
        'status_id'
    ];

    protected $with = [
        'status'
    ];

    public static array $translates = [
        'investor_representation_contract' => 'قرارداد نمایندگی سرمایه‌گذار',
        'investor_contract' => 'قرارداد سرمایه‌گذار',
        'broke_contract' => 'قرارداد کارگزاری',
        'financial_partnership_contract' => 'قرارداد مشارکت مالی',
        'three_session_project_contract' => 'قرارداد پروژه سه جلسه‌ای',
        'periodic_report' => 'گزارش دوره‌ای',
        'special_report' => 'گزارش ویژه',
        'contract' => 'قرارداد',
        'progress_report' => 'گزارش پیشرفت'
    ];





    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilterByProject($query, $projectId)
    {
        return $query->when($projectId, function ($query) use ($projectId) {
            $query->whereHas('project', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            });
        });
    }


    public function projectTitle(): Attribute
    {
        return Attribute::make(function () {
            return $this->project->shortTitle;
        });
    }

    public function userName(): Attribute
    {
        return Attribute::make(function () {
            return $this->user?->userName;
        });
    }

    public function persianType(): Attribute
    {
        return Attribute::make(function () {
            return self::$translates[$this->type];
        });
    }
}
