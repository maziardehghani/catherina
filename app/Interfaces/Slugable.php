<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Casts\Attribute;

interface Slugable
{
    public function slug():Attribute;
}
