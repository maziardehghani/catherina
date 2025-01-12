<?php

namespace Database\Seeders;

use App\Entities\City;
use App\Entities\Project;
use App\Entities\Status;
use App\Entities\User;
use App\Entities\Warranty;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
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
        $this->truncate($this->entityManager, 'projects');


        $city = $this->entityManager->find(City::class, 1);
        $warranty = $this->entityManager->find(Warranty::class, 1);
        $status = $this->entityManager->find(Status::class, 1);
        $user = $this->entityManager->find(User::class, 1);


        $numberOfProjects = 10;

        for ($i = 0; $i < $numberOfProjects; $i++) {
            $project = new Project();
            $project->setUser($user);
            $project->setTitle(fake()->title());
            $project->setSlug(fake()->unique()->slug());
            $project->setCity($city);
            $project->setPercent(fake()->numberBetween(1, 100));
            $project->setFundingPeriod(fake()->numberBetween(1, 24));
            $project->setProjectIntro(fake()->paragraph());
            $project->setProjectRisks(fake()->paragraph());
            $project->setExpertOpinion(fake()->paragraph());
            $project->setCompanyIntro(fake()->paragraph());
            $project->setStatus($status);
            $project->setWarranty($warranty);
            $project->setWarrantyDetails(fake()->paragraph());
            $project->setParticipationGenerated(fake()->boolean());

            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();





    }
}
