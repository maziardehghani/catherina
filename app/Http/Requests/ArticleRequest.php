<?php

namespace App\Http\Requests;

use App\Models\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
            'image' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'title' => ['required', 'max:255', 'min:3'],
            'slug' => ['nullable', 'max:255', 'min:3', Rule::unique('articles', 'slug')->ignore($this->route('article'))],
            'intro' => ['required', 'max:255', 'min:3'],
            'content' => ['required', 'min:3'],
            'status_id'=> ['required', Rule::exists(Status::class, 'id')],
        ];
    }
}
