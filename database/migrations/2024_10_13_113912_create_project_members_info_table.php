<?php

use App\Enums\ProjectMembersType;
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
        Schema::create('project_members_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position');
            $table->unsignedInteger('percent')->nullable();
            $table->boolean('is_owner_signiture')->nullable();
            $table->enum('type', ProjectMembersType::types());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members_info');
    }
};
