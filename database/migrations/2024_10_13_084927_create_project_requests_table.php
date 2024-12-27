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
        Schema::create('project_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('subject_plan');
            $table->string('company_name');
            $table->unsignedInteger('status_id');
            $table->string('telephone');
            $table->string('mobile');
            $table->string('register_capital');
            $table->date('establishment_year');
            $table->unsignedInteger('workers_count');
            $table->enum('company_type', ['test','test1','test2']);
            $table->enum('guarantee_type',['bank_guarantee', 'stock_guarantee','check']);
            $table->unsignedInteger('project_period_days');
            $table->string('connection_name');
            $table->string('connection_email');
            $table->string('connection_mobile');
            $table->unsignedBigInteger('required_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_requests');
    }
};
