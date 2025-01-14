<?php

namespace Database\Seeders;


use App\Entities\UsersInfosTitles;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserInfosTitleSeeder extends Seeder
{
    use DbTruncater;
    public function __construct(
        public EntityManagerInterface $entityManager
    ){}

    /**
     * Run the database seeds.
     */

    public array $titles = [
        'national_id',
        'register_code',
        'economic_code',
        'manager_name',
        'manager_national_id',
        'postal_code',
        'phone_number',
        'fax',
        'address',
        'father_name',
        'serial_number',
        'gender',
        'place_of_birth',
        'place_of_issue',
        'birth_date',
        'account_number',
        'bank_name',
        'sheba',
        'account_type',
        'company_name',
        'trading_code',
    ];
    public function run(): void
    {
        $titles = collect($this->titles);

        $titles->map(function ($title){
            $userTitle = new UsersInfosTitles();
            $userTitle->setTitle($title);
            $this->entityManager->persist($userTitle);
        });
        $this->entityManager->flush();

    }
}
