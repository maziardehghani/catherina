<?php

namespace App\Repositories\Transaction;

use App\Entities\User;
use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    public function getTransactionsOfUser(User $user)
    {
        return $this->createQueryBuilder('t')
            ->addSelect('o', 'u')
            ->innerJoin('t.order', 'o')
            ->innerJoin('o.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

    }

    public function getSumInvoicesOfUser(User $user)
    {
        return $this->createQueryBuilder('t')
            ->select('SUM(t.amount)')
            ->innerJoin('t.order', 'o')
            ->innerJoin('o.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}



//public function store($data): object
//{
//    return $this->model->create([
//        'order_id' => $data['order_id'],
//        'amount' => $data['amount'],
//        'status_id' => $data['status_id'],
//        'terminal_id' => null,
//        'trace_number' => $data['trace_number'],
//        'rrn' => null,
//        'secure_pan' => null,
//        'token' => null,
//        'gateWay' => 'receipt',
//        'created_at' => CalendarService::gregorianDate($data['date']),
//    ]);
//}
//
//public function update($model, $data):bool
//{
//    return $model->update([
//        'order_id' => $data['order_id'],
//        'amount' => $data['amount'],
//        'status_id' => $data['status_id'],
//        'terminal_id' => null,
//        'trace_number' => $data['trace_number'],
//        'rrn' => null,
//        'secure_pan' => null,
//        'token' => null,
//        'gateWay' => 'receipt',
//        'created_at' => CalendarService::gregorianDate($data['date']),
//    ]);
//}
//
//public function getSumInvoicesOfUser($user):int
//{
//    return $this->model
//        ->whereStatusTitle(Statuses::PAID)
//        ->whereUserId($user->id)
//        ->sum('amount');
//}
