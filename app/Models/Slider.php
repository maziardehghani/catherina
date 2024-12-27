<?php

namespace App\Models;

use App\Interfaces\Mediaable;
use App\Traits\HasMedia;
use App\Traits\HasSearch;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Slider extends Model implements Mediaable
{
    use HasFactory, HasMedia, HasStatus, HasSearch;

    protected $table = 'sliders';
    protected $perPage = 20;

    protected $with = ['status', 'medias'];
    protected $fillable = [
        'title',
        'order',
        'status_id',
        'link'
    ];

}
