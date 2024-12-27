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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->text('project_intro')->nullable();
            $table->text('expert_opinion')->nullable();
            $table->text('company_intro')->nullable();
            $table->text('project_risks')->nullable();
            $table->unsignedBigInteger('warranty_inquiry_id')->nullable();
            $table->text('warranty_details')->nullable();
            $table->boolean('participation_generated')->default(0);
            $table->unsignedInteger('status_id');
            $table->decimal('percent',10,2)->nullable();
            $table->unsignedInteger('funding_period')->nullable();
            $table->date('stopped_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
