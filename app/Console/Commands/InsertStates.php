<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InsertStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will perfectly insert all iran states';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('states')->truncate();

        $filename = public_path('cities/provinces.json');
        $content = File::get($filename);
        foreach (json_decode($content) as $province) {
            State::create(
                [
                    'name' => $province->name,
                ]
            );
        }
    }
}
