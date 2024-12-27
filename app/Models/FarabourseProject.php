<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarabourseProject extends Model
{
    use HasFactory;

    protected $table = 'farabourse_projects';

    protected $fillable = [
        'project_id',
        'trace_code',
        'persian_name',
        'english_name',
        'persian_symbol',
        'english_symbol',
        'industry_group',
        'sub_industry_group',
        'unit_price',
        'total_unit',
        'company_units',
        'total_amounts',
        'crowd_funding_id',
        'settlement_description',
        'crowd_funding_description',
        'minimum_require_price',
        'real_person_minimum_available_price',
        'real_person_maximum_available_price',
        'legal_person_minimum_available_price',
        'legal_person_maximum_available_price',
        'underwriting_duration',
        'suggested_underwriting_start_date',
        'suggested_underwriting_end_date',
        'approved_underwriting_start_date',
        'approved_underwriting_end_date',
        'project_start_date',
        'project_end_date',
        'project_reporting_type_description',
        'project_status_description',
        'project_status_id',
        'number_of_finance_provider',
        'sum_of_founding_provided',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
