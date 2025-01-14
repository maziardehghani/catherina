<?php

namespace Database\Seeders;

use App\Entities\Project;
use App\Entities\ProjectExperts;
use App\Entities\User;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class ProjectUserExpertSeeder extends Seeder
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
        $project2 = $this->entityManager->getRepository(Project::class)->find(2);

        $user1 = $this->entityManager->getRepository(User::class)->find(1);
        $user2 = $this->entityManager->getRepository(User::class)->find(2);



        $projectExpert1 = new ProjectExperts();

        $projectExpert1->setProject($project1)->setUser($user1);

        $this->entityManager->persist($projectExpert1);

        $projectExpert2 = new ProjectExperts();

        $projectExpert2->setProject($project2)->setUser($user2);

        $this->entityManager->persist($projectExpert2);


        $this->entityManager->flush();
    }
}
