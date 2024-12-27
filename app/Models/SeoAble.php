<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoAble extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'seoables';

    protected $with = [
        'seo',
    ];

    protected $fillable = [
        'seo_content_id',
        'seoable_type',
        'seoable_id',
        'value'
    ];

    public function seoAble(): MorphTo
    {
        return $this->morphTo();
    }

    public function seo(): BelongsTo
    {
        return $this->belongsTo(SeoContent::class, 'seo_content_id');
    }

}
