<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class TitleRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $slug = Str::of($value)->replace(' ', '_');

        if (
            !request()->slug
            &&
            Project::query()->where('slug', $slug)->exists()
        ) {
            $fail('انتخاب اسلاگ الزامی است');
        }

    }
}
