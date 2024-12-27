<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'name',
        'url',
        'mediaable_id',
        'mediaable_type',
        'type',
    ];

    public function mediaable()
    {
        return $this->morphTo();
    }

    public function scopeWhereType($query, string $type)
    {
        return $query->where('type', $type);
    }


    public function scopeWhereProject($query, Project $project)
    {
        return $query->where([
            'mediaable_id' => $project->id,
            'mediaable_type' => Project::class

        ]);
    }
}
