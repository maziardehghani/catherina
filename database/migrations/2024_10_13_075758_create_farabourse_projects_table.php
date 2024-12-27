<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('farabourse_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('trace_code')->nullable();
            $table->string('persian_name')->nullable();
            $table->string('english_name')->nullable();
            $table->string('persian_symbol')->nullable();
            $table->string('english_symbol')->nullable();
            $table->string('industry_group')->nullable();
            $table->string('sub_industry_group')->nullable();
            $table->unsignedInteger('unit_price')->nullable();
            $table->unsignedInteger('total_unit')->nullable();
            $table->unsignedInteger('company_units')->nullable();
            $table->unsignedBigInteger('total_amounts')->nullable();
            $table->unsignedInteger('crowd_funding_id')->nullable();
            $table->text('settlement_description')->nullable();
            $table->string('crowd_funding_description')->nullable();
            $table->unsignedBigInteger('minimum_require_price')->nullable();
            $table->unsignedBigInteger('real_person_minimum_available_price')->nullable();
            $table->unsignedBigInteger('real_person_maximum_available_price')->nullable();
            $table->unsignedBigInteger('legal_person_minimum_available_price')->nullable();
            $table->unsignedBigInteger('legal_person_maximum_available_price')->nullable();
            $table->unsignedInteger('underwriting_duration')->nullable();
            $table->timestamp('suggested_underwriting_start_date')->nullable();
            $table->timestamp('suggested_underwriting_end_date')->nullable();
            $table->timestamp('approved_underwriting_start_date')->nullable();
            $table->timestamp('approved_underwriting_end_date')->nullable();
            $table->timestamp('project_start_date')->nullable();
            $table->timestamp('project_end_date')->nullable();
            $table->string('project_status_description')->nullable();
            $table->unsignedTinyInteger('project_status_id')->nullable();
            $table->unsignedInteger('number_of_finance_provider')->nullable();
            $table->unsignedBigInteger('sum_of_founding_provided')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farabourse_project');
    }
};
