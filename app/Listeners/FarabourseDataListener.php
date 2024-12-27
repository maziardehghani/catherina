<?php

namespace App\Listeners;

use App\Enums\ProjectMembersType;
use App\Models\FarabourseProject;
use App\Models\Project;
use App\Models\ProjectMembersInfo;
use App\Services\FarabourseServices\FarabourseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarabourseDataListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        FarabourseProject::query()->updateOrCreate([
            'project_id' => $event->projectId,
            'trace_code' => trim($event->traceCode),
        ],[
            'creation_date' => $event->farabourseInfo['Creation Date'] ?? null,
            'persian_name' => $event->farabourseInfo['Persian Name'] ?? null,
            'persian_symbol' => $event->farabourseInfo['Persoan Approved Symbol'] ?? null,
            'english_name' => $event->farabourseInfo['English Name'] ?? null,
            'english_symbol' => $event->farabourseInfo['English Approved Symbol'] ?? null,
            'industry_group' => $event->farabourseInfo['Industry Group Description'] ?? null,
            'sub_industry_group' => $event->farabourseInfo['Sub Industry Group Description'] ?? null,
            'persian_subject' => $event->farabourseInfo['Persian Subject'] ?? null,
            'english_subject' => $event->farabourseInfo['English Subject'] ?? null,
            'unit_price' => $event->farabourseInfo['Unit Price'] ?? null,
            'total_unit' => $event->farabourseInfo['Total Units'] ?? null,
            'company_units' => $event->farabourseInfo['Company Unit Counts'] ?? null,
            'total_amounts' => $event->farabourseInfo['Total Price'] ?? null,
            'crowd_funding_id' => $event->farabourseInfo['Crowd Funding Type ID'] ?? null,
            'crowd_funding_description' => $event->farabourseInfo['Crowd Funding Type Description'] ?? null,
            'float_crowd_funding_type_description' => $event->farabourseInfo['Float Crowd Funding Type Description'] ?? null,
            'minimum_require_price' => $event->farabourseInfo['Minimum Required Price'] ?? null,
            'real_person_minimum_available_price' => $event->farabourseInfo['Real Person Minimum Availabe Price'] ?? null,
            'real_person_maximum_available_price' => $event->farabourseInfo['Real Person Maximum Available Price'] ?? null,
            'legal_person_minimum_available_price' => $event->farabourseInfo['Legal Person Minimum Availabe Price'] ?? null,
            'legal_person_maximum_available_price' => $event->farabourseInfo['Legal Person Maximum Availabe Price'] ?? null,
            'underwriting_duration' => $event->farabourseInfo['Underwriting Duration'] ?? null,
            'suggested_underwriting_start_date' => $event->farabourseInfo['Suggested Underwriting Start Date'] ?? null,
            'suggested_underwriting_end_date' => $event->farabourseInfo['Suggested Underwriting End Date'] ?? null,
            'approved_underwriting_start_date' => $event->farabourseInfo['Approved Underwriting Start Date'] ?? null,
            'approved_underwriting_end_date' => $event->farabourseInfo['Approved Underwriting End Date'] ?? null,
            'project_start_date' => $event->farabourseInfo['Project Start Date'] ?? null,
            'project_end_date' => $event->farabourseInfo['Project End Date'] ?? null,
            'settlement_description' => $event->farabourseInfo['Settlement Description'] ?? null,
            'project_status_description' => $event->farabourseInfo['Project Status Description'] ?? null,
            'project_status_id' => $event->farabourseInfo['Project Status ID'] ?? null,
            'persian_suggested_underwriting_start_date' => $event->farabourseInfo['Persian Suggested Underwiring Start Date'] ?? null,
            'persian_suggested_underwriting_end_date' => $event->farabourseInfo['Persian Suggested Underwiring Start Date'] ?? null,
            'persian_approved_underwriting_start_date' => $event->farabourseInfo['Persian Approved Underwriting Start Date'] ?? null,
            'persian_approved_underwriting_end_date' => $event->farabourseInfo['Persian Approved Underwriting End Date'] ?? null,
            'persian_project_start_date' => $event->farabourseInfo['Persian Project Start Date'] ?? null,
            'persian_project_end_date' => $event->farabourseInfo['Persian Project End Date'] ?? null,
            'persian_creation_Date' => $event->farabourseInfo['Persian Creation Date'] ?? null,
            'sum_of_founding_provided' => $event->farabourseInfo['SumOfFundingProvided'] ?? null,
            'number_of_finance_provider' => $event->farabourseInfo['Number of Finance Provider'] ?? null,

        ]);
    }
}
