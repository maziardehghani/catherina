<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InsertCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will perfectly insert all iran cities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('cities')->truncate();


        $filename = public_path('cities/cities.json');
        $content = File::get($filename);
        foreach (json_decode($content) as $city) {
            City::create(
                [
                    'name' => $city->name,
                    'state_id' => $city->province_id,
                ]
            );
        }
    }
}
