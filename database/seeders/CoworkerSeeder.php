<?php

namespace Database\Seeders;

use App\Models\Coworker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoworkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coworker::factory()->count(10)->create();
    }
}
