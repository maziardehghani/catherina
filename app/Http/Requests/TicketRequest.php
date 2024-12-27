<?php

namespace App\Http\Requests;

use App\Enums\TicketCategories;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            //'subject' => [Rule::requiredIf(request()->isMethod('POST')), 'max:255', 'min:3'],
            'content' => [Rule::requiredIf(request()->isMethod('POST')), 'max:255', 'min:3'],
            'status_id' => ['nullable', 'integer', Rule::exists('statuses', 'id')],
            //'category' => [Rule::requiredIf(!(request()->routeIs('admin.tickets.answer'))), Rule::in(TicketCategories::categories())]
        ];

        return $rule;

    }
}
