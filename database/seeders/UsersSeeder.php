<?php

namespace Database\Seeders;

use App\Entities\Status;
use App\Entities\User;
use App\Enums\UserTypes;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
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

        $this->truncate($this->entityManager, 'users');

        $status = $this->entityManager->find(Status::class, 1);

        $batchSize = 20;
        $totalUsers = 10;

        for ($i = 1; $i <= $totalUsers; $i++) {
            $user = new User();
            $user->setName(fake()->firstName());
            $user->setFamily(fake()->lastName());
            $user->setEmail(fake()->unique()->safeEmail());
            $user->setMobile(fake()->unique()->phoneNumber());
            $user->setIsSejami(fake()->boolean());
            $user->setIsPrivateInvestor(fake()->boolean());
            $user->setStatus($status); // Set status (pre-fetched)
            $user->setBio(fake()->text());
            $user->setType(fake()->randomElement(UserTypes::userTypes()));
            $user->setPassword(fake()->password());

            $this->entityManager->persist($user);

            if ($i % $batchSize === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
