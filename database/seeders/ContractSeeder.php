<?php

namespace Database\Seeders;


use App\Entities\Contract;
use App\Entities\Project;
use App\Entities\User;
use App\Enums\ContractTypes;
use App\Enums\DocumentTypes;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContractSeeder extends Seeder
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
        $this->truncate($this->entityManager,'contracts');

        $user = $this->entityManager->find(User::class, 1);
        $project = $this->entityManager->find(Project::class, 1);

        $this->entityManager->getConnection()->beginTransaction();

        try {
            $numberOfContracts = 10;

            for ($i = 0; $i < $numberOfContracts; $i++) {
                $contract = new Contract();
                $contract->setUser(fake()->randomElement($user));
                $contract->setProject(fake()->randomElement($project));
                $contract->setTitle(fake()->title());
                $contract->setDescription(fake()->text());
                $contract->setType(fake()->randomElement(ContractTypes::cases()));
                $contract->setDocumentType(fake()->randomElement(DocumentTypes::cases()));

                $this->entityManager->persist($contract);
            }

            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();

        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            Log::error('Error in ContractSeeder: ' . $e->getMessage());
        }
    }
}
