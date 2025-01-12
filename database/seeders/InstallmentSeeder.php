<?php

namespace Database\Seeders;

use App\Entities\Installment;
use App\Entities\Invoice;
use App\Entities\Status;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class InstallmentSeeder extends Seeder
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
        $this->truncate($this->entityManager,'installments');

        $invoices = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Invoice::class, 'i')
            ->getQuery()
            ->getResult();

        $status = $this->entityManager->find(Status::class, 1);


        foreach ($invoices as $invoice) {

            for($i = 0; $i <= 4; $i++){

                $installment = new Installment();
                $installment->setInvoice($invoice);
                $installment->setAmount(fake()->numberBetween(1, 999999));
                $installment->setDescription(fake()->text());
                $installment->setDueDate(fake()->dateTime());
                $installment->setStatus($status);
                $this->entityManager->persist($installment);
            }

            $this->entityManager->flush();

        }
    }
}
