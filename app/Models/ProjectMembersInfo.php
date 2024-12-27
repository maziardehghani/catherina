<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMembersInfo extends Model
{
    use HasFactory;

    protected $table = 'project_members_info';

    protected $fillable = [
        'project_id',
        'first_name',
        'last_name',
        'position',
        'percent',
        'is_owner_signiture',
        'type',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
