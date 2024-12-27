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
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Coworker extends Model implements Mediaable
{
    use HasFactory, HasMedia, HasStatus, HasSearch;

    protected $table = 'coworkers';

    protected $perPage= 20;

    protected $with = [
        'medias',
        'status'
    ];

    protected $fillable = [
        'title',
        'link',
        'status_id'
    ];

    public function mediaFile():Attribute
    {
        return Attribute::make(function (){
            return $this->medias?->url;
        });
    }

}
