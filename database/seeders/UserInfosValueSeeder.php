<?php

namespace Database\Seeders;


use App\Entities\User;
use App\Entities\UsersInfosTitles;
use App\Entities\UsersInfosValues;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class UserInfosValueSeeder extends Seeder
{

    use DbTruncater;

    public function __construct(
        public EntityManagerInterface $entityManager
    ) {}

    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $this->truncate($this->entityManager,'users_infos_values');
        $users = $this->entityManager->getRepository(User::class)->findAll();

        collect($users)->map(function ($user) {


            $data = [
                ['user_info_title_id' => 1, 'value' => fake()->unique()->numerify('##########')],
                ['user_info_title_id' => 2, 'value' => fake()->unique()->numerify('##########')],
                ['user_info_title_id' => 3, 'value' => fake()->unique()->numerify('##########')],
                ['user_info_title_id' => 4, 'value' => fake()->name()],
                ['user_info_title_id' => 5, 'value' => fake()->unique()->numerify('##########')],
                ['user_info_title_id' => 6, 'value' => fake()->unique()->numerify('##########')],
                ['user_info_title_id' => 7, 'value' => fake()->numerify('##########')],
                ['user_info_title_id' => 8, 'value' => fake()->numerify('##########')],
                ['user_info_title_id' => 9, 'value' => fake()->address()],
                ['user_info_title_id' => 10, 'value' => fake()->name()],
                ['user_info_title_id' => 11, 'value' => fake()->unique()->numerify('#########')],
                ['user_info_title_id' => 12, 'value' => 'male'],
                ['user_info_title_id' => 13, 'value' => fake()->city()],
                ['user_info_title_id' => 14, 'value' => fake()->city()],
                ['user_info_title_id' => 15, 'value' => fake()->date()],
                ['user_info_title_id' => 16, 'value' => fake()->numerify('#########')],
                ['user_info_title_id' => 17, 'value' => fake()->randomElement(config('bank.bankLists'))['name']],
                ['user_info_title_id' => 18, 'value' => fake()->numerify('##################')],
                ['user_info_title_id' => 19, 'value' => fake()->title()],
                ['user_info_title_id' => 20, 'value' => fake()->company()],
                ['user_info_title_id' => 21, 'value' => fake()->numerify('#####')],
            ];

            foreach ($data as $item) {
                $title = $this->entityManager->getRepository(UsersInfosTitles::class)->find($item['user_info_title_id']);

                $userInfoValue = new UsersInfosValues();
                $userInfoValue->setUser($user);
                $userInfoValue->setUserTitleInfo($title);
                $userInfoValue->setValue($item['value']);
                $this->entityManager->persist($userInfoValue);
            }

            $this->entityManager->flush();
        });
    }
}
