<?php

namespace App\Http\Requests;

use App\Enums\ContractTypes;
use App\Enums\Statuses;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'project_id' => 'required|integer|exists:projects,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(ContractTypes::contracts())],
            'document_type' => ['required', Rule::in(['contract', 'progress_report'])],
            'status_id' => ['required', 'integer'],
        ];
    }
}
