<?php

namespace Database\Seeders;


use App\Entities\Installment;
use App\Entities\Invoice;
use App\Entities\Order;
use App\Entities\Project;
use App\Entities\Status;
use App\Entities\Transaction;
use App\Entities\User;
use App\Enums\GateWays;
use App\Traits\DbTruncater;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class InvoiceSeeder extends Seeder
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

        $this->truncate($this->entityManager,'invoices');
        $this->truncate($this->entityManager,'transactions');
        $this->truncate($this->entityManager,'orders');


        $user = $this->entityManager->find(User::class, 1);
        $project = $this->entityManager->find(Project::class, 1);



        $this->entityManager->getConnection()->beginTransaction();
        try {


            for ($i = 0; $i < 10; $i++  ) {

                $status = $this->entityManager->find(Status::class, fake()->numberBetween(3,7));


                $order = new Order();
                $order->setUser($user);
                $order->setProject($project);


                $transaction = new Transaction();
                $transaction->setStatus($status);
                $transaction->setAmount(fake()->numberBetween(1, 999999));
                $transaction->setRrn(fake()->numberBetween(1, 999999));
                $transaction->setSecurePan(fake()->numberBetween(1,999999));
                $transaction->setTerminalId(fake()->numberBetween(1, 999999));
                $transaction->setGateway(GateWays::ONLINE);
                $transaction->setTraceNumber(fake()->numberBetween(1, 999999));
                $transaction->setToken(fake()->numberBetween(1, 999999));
                $transaction->setOrder($order);



                $invoice = new Invoice();
                $invoice->setTraceCode(fake()->shuffleString());
                $invoice->setTermConditionAccepted(fake()->boolean());
                $invoice->setTransaction($transaction);

                $this->entityManager->persist($order);
                $this->entityManager->persist($transaction);
                $this->entityManager->persist($invoice);
            }

            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();


        }catch (\Exception $e){
            $this->entityManager->getConnection()->rollBack();
            Log::error($e->getMessage());
        }

    }
}
