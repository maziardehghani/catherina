<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $state = State::query()->create([
            'name' => 'اصفهان'
        ]);

        $city = City::query()->create([
            'name' => 'زرینشهر',
            'state_id' => $state->id
        ]);
    }
}
