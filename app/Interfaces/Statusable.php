<?php

namespace App\Interfaces;

use App\Models\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Statusable
{
    public function status(): BelongsTo;

    public function statusTitle():Attribute;

}
