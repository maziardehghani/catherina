<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class InstallmentRequest extends FormRequest
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
        Log::error($this);
        return [
            'due_dates' => ['array', Rule::requiredIf(fn() => $this->route()->getName() === "installments.submitInstallments")],
            'due_date.*' => [Rule::requiredIf(fn() => $this->route()->getName() === "installments.submitInstallments")],
            'due_date' => ['date', Rule::requiredIf(fn() => $this->route()->getName() === "admin.installments.payInstallments")],
            'payment_date' => ['nullable','date',],
            'status_id' => ['integer', Rule::requiredIf(fn() => $this->route()->getName() === "admin.installments.payInstallments")],
            'description' => ['nullable', 'string'],
        ];

    }
}
