<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoContent extends Model
{
    use HasFactory ;

    protected $fillable = [
        'name',
        'alias'
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => (isset($this->name) && isset($this->alias)) ? $this->name . " ( " . $this->alias . " )" : $this->name,
        );
    }

    public function scopeTitle($query)
    {
        return $query->where('name', 'title');
    }

    public function scopeDescription($query)
    {
        return $query->where('name',  'description');
    }

    public function scopeCanonical($query)
    {
        return $query->where('name',  'Canonical');
    }

    public function scopeOgTitle($query)
    {
        return $query->where('name',  'og:title');
    }

    public function scopeOgDescription($query)
    {
        return $query->where('name',  'og:description');
    }

    public function scopeOgImage($query)
    {
        return $query->where('name',  'og:image');
    }

    public function scopeOgUrl($query)
    {
        return $query->where('name',  'og:url');
    }

    public function scopeOgType($query)
    {
        return $query->where('name',  'og:type');
    }

    public function scopeTwitterCard($query)
    {
        return $query->where('name',  'twitter:card');
    }

    public function scopeKeywords($query)
    {
        return $query->where('name',  'keywords');
    }

    public function scopeSchema($query)
    {
        return $query->where('name',  'schema');
    }

    public function scopeH1($query)
    {
        return $query->where('name',  'h1');
    }
}
