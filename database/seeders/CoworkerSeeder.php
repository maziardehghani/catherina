<?php

namespace Database\Seeders;

use App\Entities\Coworker;
use App\Entities\Status;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class CoworkerSeeder extends Seeder
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
        $this->truncate($this->entityManager,'coworkers');
        $status = $this->entityManager->find(Status::class,1);

        for ($i = 0; $i < 10; $i++) {
            $entity = new Coworker();
            $entity->setTitle(fake()->sentence(3));
            $entity->setLink(fake()->url());
            $entity->setStatus($status);

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }
}
