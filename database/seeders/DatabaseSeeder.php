<?php

namespace Database\Seeders;

use App\Entities\Contract;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            WarrantiesSeeder::class,
            StatusesSeeder::class,
            UsersSeeder::class,
            ProjectSeeder::class,
            InvoiceSeeder::class,
            InstallmentSeeder::class,
            ArticleSeeder::class,
            ContractSeeder::class,
            CoworkerSeeder::class,
            ProjectUserExpertSeeder::class
        ]);
    }
}
