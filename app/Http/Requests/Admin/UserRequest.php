<?php

namespace App\Http\Requests\Admin;

use App\Enums\Statuses;
use App\Enums\UserTypes;
use App\Models\User;
use App\Rules\MelliCodeIdentity;
use App\Rules\UniqueUserInfoValue;
use App\Rules\ValidMobileRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        return [
            'type' => [
                'required',
                Rule::in(UserTypes::userTypes()),
            ],
            'company_name' => [
                'nullable',
                Rule::requiredIf($this->type == 'legal'),
                'string',
                'max:30',
                'min:3',
            ],
            'name' => [
                'nullable',
                Rule::requiredIf($this->type == 'real'),
                'string',
                'max:30',
                'min:3'
            ],
            'family' => [
                'nullable',
                Rule::requiredIf($this->type == 'real'),
                'string',
                'max:30',
                'min:3'
            ],
            'national_id' => [
                'nullable',
                Rule::requiredIf($this->type == 'real'),
                'string',
//                new MelliCodeIdentity(),
                new UniqueUserInfoValue()
            ],
            'register_code' => [
                'nullable',
                Rule::requiredIf($this->type == 'legal'),
                'string',
                'max:30',
                'min:3',
                new UniqueUserInfoValue()
            ],
            'economic_code' => [
                'nullable',
                Rule::requiredIf($this->type == 'legal'),
                'string',
                'max:30',
                'min:3',
                new UniqueUserInfoValue()
            ],
            'manager_name' => [
                'nullable',
                'string',
                'max:30',
                'min:3',
            ],
            'manager_national_id' => [
                'nullable',
                'string',
//                new MelliCodeIdentity(),
                new UniqueUserInfoValue()
            ],
            'phone_number' => [
                'nullable',
                'string',
                new ValidMobileRule(),
                new UniqueUserInfoValue()

            ],
            'fax' => [
                'nullable',
                'string',
                'max:20',
                'min:3',
            ],
            'address' => [
                'nullable',
                Rule::requiredIf($this->type == 'legal'),
                'string',
                'max:255',
                'min:3',
            ],
            'father_name' => [
                'nullable',
                'string',
                'max:30',
                'min:3'
            ],

            'serial_number' => [
                'nullable',
                'string',
                'max:30',
                'min:3',
                new UniqueUserInfoValue()
            ],

            'place_of_birth' => [
                'nullable',
                'string',
                'max:30',
                'min:3'
            ],

            'birth_date' => [
                'nullable',
                'date',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->user?->getId()),
            ],

            'mobile' => [
                'required',
                'string',
                Rule::unique(User::class, 'mobile')->ignore($this->user?->getId()),
                new ValidMobileRule()
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'bio' => [
                'nullable',
                'string'
            ],
            'gender' => [
                'nullable',
                'in:male,female'
            ],
            'is_private_investor' => [
                'nullable',
                'boolean'
            ],
            'is_sejami' => [
                'required',
                'boolean'
            ],
            'profile' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,svg'
            ],
            'password' => [
                Rule::requiredIf($this->method == 'post'),
                'string',
                'min:8'
            ],
            'trading_code' => [
                'nullable',
                Rule::requiredIf((bool)$this->is_sejami),
                'string',
                'max:20',
                'min:5',
                new UniqueUserInfoValue(),
            ],
            'bank_name' => [
                'nullable',
                'required_with:account_number,sheba,accountType',
                'string',
                'max:30',
                'min:3',
            ],
            'account_number' => [
                'nullable',
                'required_with:bank_name,sheba,accountType',
                'string',
                'max:30',
                'min:3',
                new UniqueUserInfoValue()

            ],
            'sheba' => [
                'nullable',
                'required_with:bank_name,account_number,accountType',
                'string',
                'max:30',
                'min:3',
                new UniqueUserInfoValue()
            ],
            'account_type' => [
                'nullable',
                'required_with:bank_name,account_number,sheba',
                'string',
                'max:30',
                'min:3',
            ],
            'postal_code' => [
                'nullable',
                'digits:10'
            ],
            'place_of_issue'=>[
                'nullable',
                'string',
                'max:225',
                'min:3'
            ]
        ];
    }
}
