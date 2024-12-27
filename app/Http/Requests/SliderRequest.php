<?php

namespace App\Http\Requests;

use App\Models\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderRequest extends FormRequest
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
            'title' => ['required', 'string' , 'max:255' , 'min:3'],
            'link' => ['required', 'string' , 'max:255' , 'min:3',],
            'order' => ['required', 'integer', 'min:1'],
            'status_id' => ['required', 'integer', Rule::exists(Status::class, 'id')],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
