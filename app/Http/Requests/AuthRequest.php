<?php

namespace App\Http\Requests;

use App\Rules\ValidMobileRule;
use App\Services\CodeService\VerifyCodeService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rule = [];

        if (request()->route()->getName() == 'auth.send_code')
        {
            $rule = [
                'mobile' => ['required', 'string', 'max:11', 'min:9', new ValidMobileRule()],
            ];
        }

        if (request()->route()->getName() == 'auth.verifyCode')
        {
            $rule = [
                'mobile' => ['required', 'string', 'max:11', 'min:9', new ValidMobileRule()],
                'code' => VerifyCodeService::getRule(),
            ];
        }

        return $rule;
    }
}
