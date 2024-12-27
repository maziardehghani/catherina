<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasSlug
{
    public function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value ?: Str::of($this->title)->replace(' ', '_')
        );
    }
}
