<?php

namespace App\Http\Requests;

use App\Enums\Statuses;
use App\Models\City;
use App\Models\FarabourseProject;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use App\Models\Warranty;
use App\Rules\TitleRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'title' => [
                Rule::requiredIf($this->routeIs('admin.projects.storeSpecifications')),
                new TitleRule(),
                'string'
            ],
            'slug' => [
                'nullable',
                'string',
                Rule::unique(Project::class, 'slug')->ignore($this->project_id)
            ],
            'user_id' => [
                Rule::requiredIf($this->routeIs('admin.projects.storeSpecifications')),
                'integer',
                Rule::exists(User::class, 'id')
            ],
            'city_id' => [
                Rule::requiredIf($this->routeIs('admin.projects.storeSpecifications')),
                'integer',
                Rule::exists(City::class, 'id')
            ],
            'project_id' => [
                'nullable',
                'integer',
                Rule::exists(Project::class, 'id')
            ],
            'project_intro' => [
                Rule::requiredIf($this->routeIs('admin.projects.projectInformation')),
                'string',
                'max:255'
            ],
            'expert_opinion' => [
                Rule::requiredIf($this->routeIs('admin.projects.projectInformation')),
                'string',
                'max:255'
            ],
            'company_intro' => [
                Rule::requiredIf($this->routeIs('admin.projects.projectInformation')),
                'string',
                'max:255'
            ],
            'project_risks' => [
                Rule::requiredIf($this->routeIs('admin.projects.projectInformation')),
                'string',
                'max:255'
            ],
            'percent' => [
                Rule::requiredIf($this->routeIs('admin.projects.financialInformation')),
                'numeric'
            ],
            'funding_period' => [
                Rule::requiredIf($this->routeIs('admin.projects.financialInformation')),
                'integer'
            ],
            'warranty_inquiry_id' => [
                Rule::requiredIf($this->routeIs('admin.projects.financialInformation')),
                'integer',
                Rule::exists(Warranty::class, 'id')
            ],
            'warranty_details' => [
                Rule::requiredIf($this->routeIs('admin.projects.financialInformation')),
                'string',
                'max:255'
            ],
            'status_id'=>[
                Rule::requiredIf($this->routeIs('admin.projects.status')),
                'integer',
                Rule::exists(Status::class, 'id'),
            ],
            'trace_code' => [
                Rule::requiredIf($this->routeIs('admin.projects.getFarabourseProject')),
                Rule::unique(FarabourseProject::class, 'trace_code')->ignore($this->project?->farabourse?->id),
                'string'
            ]
        ];
    }
}
