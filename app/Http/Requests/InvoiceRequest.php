<?php

namespace App\Http\Requests;

use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
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
            'trace_number' => ['required'],
            'amount' => ['required', 'integer'],
            'status_id' => ['required', Rule::exists(Status::class, 'id')],
            'project_id' => ['required', Rule::exists(Project::class, 'id')],
            'user_id' => ['required', Rule::exists(User::class,'id')],
            'date' => ['nullable', 'date'],
            'receipt' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,pdf,doc,docx'],
        ];
    }
}
