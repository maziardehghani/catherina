<?php

namespace App\Http\Resources;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarabourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trace_code' => $this->trace_code,
            'persian_name' => $this->persian_name,
            'english_name' => $this->english_name,
            'persian_symbol' => $this->persian_symbol,
            'english_symbol' => $this->english_symbol,
            'industry_group' => $this->industry_group,
            'sub_industry_group' => $this->sub_industry_group,
            'unit_price' => $this->unit_price,
            'total_unit' => $this->total_unit,
            'company_units' => $this->company_units,
            'total_amounts' => $this->total_amounts,
            'crowd_funding_id' => $this->crowd_funding_id,
            'settlement_description' => $this->settlement_description,
            'crowd_funding_type_description' => $this->crowd_funding_type_description,
            'crowd_funding_description' => $this->crowd_funding_description,
            'minimum_require_price' => $this->minimum_require_price,
            'real_person_minimum_available_price' => $this->real_person_minimum_available_price,
            'real_person_maximum_available_price' => $this->real_person_maximum_available_price,
            'legal_person_minimum_available_price' => $this->legal_person_minimum_available_price,
            'legal_person_maximum_available_price' => $this->legal_person_maximum_available_price,
            'underwriting_duration' => $this->underwriting_duration,
            'suggested_underwriting_start_date' => $this->suggested_underwriting_start_date,
            'suggested_underwriting_end_date' => $this->suggested_underwriting_end_date,
            'approved_underwriting_start_date' => $this->approved_underwriting_start_date,
            'approved_underwriting_end_date' => $this->approved_underwriting_end_date,
            'project_start_date' => $this->project_start_date,
            'project_end_date' => $this->project_end_date,
            'project_reporting_type_description' => $this->project_reporting_type_description,
            'project_status_description' => $this->project_status_description,
            'project_status_id' => $this->project_status_id,
            'number_of_finance_provider' => $this->number_of_finance_provider,
            'sum_of_founding_provided' => $this->sum_of_founding_provided,
            'created_at' => CalendarService::getDate($this->updated_at)
        ];
    }
}
