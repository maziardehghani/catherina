<?php

namespace Database\Seeders;

use App\Models\ProjectUserExpert;
use Illuminate\Database\Seeder;

class ProjectUserExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectUserExpert::factory()->count(2)->create();
    }
}
