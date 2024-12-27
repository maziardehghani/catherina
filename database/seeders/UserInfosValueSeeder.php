<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfoTitle;
use App\Models\UserInfoValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserInfosValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $users = User::all();

        $users->map(function ($user) {

            // national id
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 1,
                'value' => fake()->unique()->numerify('##########')
            ]);

            //register_code
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 2,
                'value' => fake()->unique()->numerify('##########')
            ]);

            //economice code
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 3,
                'value' => fake()->unique()->numerify('##########')
            ]);

            //manager_name
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 4,
                'value' => fake()->name
            ]);

            //manager national id
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 5,
                'value' => fake()->unique()->numerify('##########')
            ]);

            //postal code
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 6,
                'value' => fake()->unique()->numerify('##########')
            ]);

            //phone_number
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 7,
                'value' => fake()->numerify('##########')
            ]);

            //fax
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 8,
                'value' => fake()->numerify('##########')
            ]);

            // address
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 9,
                'value' => fake()->address()
            ]);

            //father_name
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 10,
                'value' => fake()->name()
            ]);

            //serial_number
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 11,
                'value' => fake()->unique()->numerify('#########')
            ]);

            //gender
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 12,
                'value' => 'male'
            ]);

            //place_of_birth
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 13,
                'value' => fake()->city()
            ]);

            //place_of_issue
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 14,
                'value' => fake()->city()
            ]);


            //birth_date
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 15,
                'value' => fake()->date()
            ]);


            //account_number
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 16,
                'value' => fake()->numerify('#########')
            ]);


            //bank_name
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 17,
                'value' => fake()->randomElement(config('bank.bankLists'))['name']
            ]);

            //sheba
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 18,
                'value' => fake()->numerify('##################')
            ]);

            //accountType
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 19,
                'value' => fake()->title()
            ]);

            //company_name
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 20,
                'value' => fake()->company()
            ]);

            //trading_code
            UserInfoValue::query()->create([
                'user_id' => $user->id,
                'user_info_title_id' => 21,
                'value' => fake()->numerify('#####')
            ]);

        });
    }
}
