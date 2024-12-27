<?php

namespace App\Rules;

use App\Models\UserInfoValue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueUserInfoValue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $valueExist = UserInfoValue::query()
            ->whereTitle($attribute)
            ->whereValue($value)
            ->whereNotUserId(request()->user?->id)
            ->first();

        if ($valueExist) {
            $fail(":attribute قبلا انتخاب شده است");
        }

    }
}
