<?php

namespace Database\Seeders;

use App\Entities\City;
use App\Entities\FarabourseProject;
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


            $farabourseProject = new FarabourseProject();
            $farabourseProject->setProject($project);
            $farabourseProject->setTraceCode(fake()->uuid);
            $farabourseProject->setPersianName(fake()->company . ' (FA)');
            $farabourseProject->setEnglishName(fake()->company . ' (EN)');
            $farabourseProject->setPersianSymbol('SYM-' . fake()->randomLetter);
            $farabourseProject->setEnglishSymbol('SYM-' . strtoupper(fake()->randomLetter));
            $farabourseProject->setIndustryGroup(fake()->word);
            $farabourseProject->setSubIndustryGroup(fake()->word);
            $farabourseProject->setUnitPrice(fake()->randomFloat(2, 1000, 5000));
            $farabourseProject->setTotalUnit(fake()->numberBetween(100, 1000));
            $farabourseProject->setCompanyUnits(fake()->numberBetween(10, 100));
            $farabourseProject->setTotalAmounts(fake()->randomFloat(2, 100000, 500000));
            $farabourseProject->setCrowdFundingId($i);
            $farabourseProject->setSettlementDescription(fake()->sentence);
            $farabourseProject->setCrowdFundingDescription(fake()->paragraph);
            $farabourseProject->setMinimumRequirePrice(fake()->randomFloat(2, 500, 1000));
            $farabourseProject->setRealPersonMinimumAvailablePrice(fake()->randomFloat(2, 100, 500));
            $farabourseProject->setRealPersonMaximumAvailablePrice(fake()->randomFloat(2, 500, 1000));
            $farabourseProject->setLegalPersonMinimumAvailablePrice(fake()->randomFloat(2, 200, 600));
            $farabourseProject->setLegalPersonMaximumAvailablePrice(fake()->randomFloat(2, 600, 1200));
            $farabourseProject->setUnderwritingDuration(fake()->numberBetween(30, 90));
            $farabourseProject->setSuggestedUnderwritingStartDate(fake()->dateTimeThisYear);
            $farabourseProject->setSuggestedUnderwritingEndDate(fake()->dateTimeThisYear('+2 months'));
            $farabourseProject->setApprovedUnderwritingStartDate(fake()->dateTimeThisYear('+3 months'));
            $farabourseProject->setApprovedUnderwritingEndDate(fake()->dateTimeThisYear('+5 months'));
            $farabourseProject->setProjectStartDate(fake()->dateTimeThisYear('+6 months'));
            $farabourseProject->setProjectEndDate(fake()->dateTimeThisYear('+12 months'));
            $farabourseProject->setProjectReportingTypeDescription(fake()->sentence);
            $farabourseProject->setProjectStatusDescription(fake()->sentence);
            $farabourseProject->setProjectStatusId(fake()->numberBetween(1, 5));
            $farabourseProject->setNumberOfFinanceProvider(fake()->numberBetween(1, 50));
            $farabourseProject->setSumOfFoundingProvided(fake()->randomFloat(2, 50000, 100000));

            $this->entityManager->persist($project);
            $this->entityManager->persist($farabourseProject);
        }

        $this->entityManager->flush();





    }
}
