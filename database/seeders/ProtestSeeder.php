<?php

namespace Database\Seeders;

use App\Entities\Project;
use App\Entities\ProjectExperts;
use App\Entities\Protest;
use App\Entities\User;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProtestSeeder extends Seeder
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
        $this->truncate($this->entityManager,'project_user_experts');

        $project1 = $this->entityManager->getRepository(Project::class)->find(1);

        $user1 = $this->entityManager->getRepository(User::class)->find(1);



       for ($i = 0; $i < 10; $i++){
           $projectExpert1 = new Protest();

           $projectExpert1->setProject($project1)->setUser($user1);
           $projectExpert1->setContent(fake()->text());
           $this->entityManager->persist($projectExpert1);
       }



        $this->entityManager->flush();
    }
}
