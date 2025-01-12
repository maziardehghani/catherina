<?php

namespace Database\Seeders;

use App\Entities\Warranty;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Illuminate\Database\Seeder;

class WarrantiesSeeder extends Seeder
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
        $this->truncate($this->entityManager, 'warranties');


        for ($i = 0; $i < 10; $i++) {
            $entity = new Warranty();
            $entity->setTitle(fake()->title());
            $entity->setLink(fake()->url);

            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();


    }
}
