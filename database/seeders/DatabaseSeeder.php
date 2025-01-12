<?php

namespace Database\Seeders;

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
//            UserInfosTitleSeeder::class,
//            UserInfosValueSeeder::class,
//            PermissionSeeder::class,
//            ArticleSeeder::class,
//            SliderSeeder::class,
//            TicketSeeder::class,
//            CoworkerSeeder::class,
//            ProjectUserExpertSeeder::class,
//            ContractSeeder::class,
//            CommentSeeder::class,
        ]);
    }
}
