<?php

namespace Database\Seeders;

use App\Entities\Status;
use App\Entities\User;
use App\Enums\Statuses;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    use DbTruncater;

    public function __construct(
        public EntityManagerInterface $entityManager
    ){}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->truncate($this->entityManager, 'statuses');

        collect(Statuses::commonStatuses())->map(function ($item) {
            $status = new Status();
            $status->setTitle($item);
            $status->setModel(User::class);
            $this->entityManager->persist($status);
            $this->entityManager->flush();

        });


    }
}
