<?php

namespace Database\Seeders;

use App\Entities\Installment;
use App\Entities\Invoice;
use App\Entities\Order;
use App\Entities\Project;
use App\Entities\Transaction;
use App\Entities\User;
use App\Enums\GateWays;
use App\Enums\Statuses;
use App\Enums\TransactionStatuses;
use App\Enums\UserTypes;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $em = app(EntityManagerInterface::class);

        $em->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 0');
        $em->getConnection()->executeStatement('TRUNCATE TABLE users');
        $em->getConnection()->executeStatement('TRUNCATE TABLE invoices');
        $em->getConnection()->executeStatement('TRUNCATE TABLE transactions');
        $em->getConnection()->executeStatement('TRUNCATE TABLE orders');
        $em->getConnection()->executeStatement('TRUNCATE TABLE projects');


        $em->getConnection()->beginTransaction();

        try {

            $user = new User();
            $user->setName('maziar');
            $user->setFamily('dehqani');
            $user->setIsPrivateInvestor(true);
            $user->setMobile('09931591988');
            $user->setEmail('maziar@gmail.com');
            $user->setType(UserTypes::REAL);
            $user->setIsSejami(true);
            $user->setStatusId(1);
            $user->setBio('test');
            $user->setPassword(242345234523);


            $project = new Project();
            $project->setTitle('tset projcet');

            for ($i = 0; $i < 100; $i++  ) {
                $order = new Order();
                $order->setUser($user);
                $order->setProject($project);


                $transaction = new Transaction();
                $transaction->setStatus(TransactionStatuses::PAID);
                $transaction->setAmount(1000);
                $transaction->setRrn('35325');
                $transaction->setSecurePan(3523456456);
                $transaction->setTerminalId(3452534);
                $transaction->setGateway(GateWays::ONLINE);
                $transaction->setTraceNumber('5234562');
                $transaction->setToken('5234562456');
                $transaction->setOrder($order);



                $invoice = new Invoice();
                $invoice->setTraceCode('45252345');
                $invoice->setTermConditionAccepted(true);
                $invoice->setTransaction($transaction);


                $installment = new Installment();
                $installment->setInvoice($invoice);
                $installment->setAmount(1000);
                $installment->setDescription('test');
                $installment->setDueDate(Carbon::now());
                $installment->setStatus(TransactionStatuses::PAID);

                $em->persist($order);
                $em->persist($transaction);
                $em->persist($invoice);
                $em->persist($installment);
            }

            $em->persist($user);
            $em->persist($project);

            $em->flush();

            $em->getConnection()->commit();


        }catch (\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
        }



        $em->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS = 1');


    }
}
