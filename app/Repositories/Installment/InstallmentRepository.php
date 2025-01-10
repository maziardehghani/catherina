<?php

namespace App\Repositories\Installment;

use App\Entities\User;
use App\Enums\Statuses;
use App\Models\Installment;
use App\Models\Status;
use App\Repositories\Repository;
use App\Services\CalendarServices\CalendarService;
use Doctrine\ORM\EntityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class InstallmentRepository extends EntityRepository
{
    public function getInstallmentsOfUser(User $user)
    {
        return $this->createQueryBuilder('i')
            ->addSelect('inv', 't', 'o')
            ->join('i.invoice', 'inv')
            ->join('inv.transaction', 't')
            ->join('t.order', 'o')
            ->where('o.user = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

    }

    public function getSumInstallmentsOfUser(User $user)
    {
        return $this->createQueryBuilder('i')
            ->select('SUM(i.amount)')
            ->join('i.invoice', 'inv')
            ->join('inv.transaction', 't')
            ->join('t.order', 'o')
            ->where('o.user = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}





//public function deleteInstallmentsOfProject($project)
//{
//    $this->model->whereHas('invoice', function ($query) use ($project) {
//        $query->whereHas('transaction', function ($query) use ($project) {
//            $query->whereHas('order', function ($query) use ($project) {
//                $query->whereHas('orderable', function ($query) use ($project) {
//                    $query->where('id', $project->id);
//                });
//            });
//        });
//    })->delete();
//}
//
//public function getInstallmentsOfProjectforDueDate($project, $due_date)
//{
//    return $this->model
//        ->whereHas('invoice.transaction.order.orderable', function ($query) use ($project) {
//            $query->where('id', $project->id);
//        })->where('due_date',$due_date)->get();
//}
//
//public function store(array|object $data): object
//{
//    return $this->model->create([
//        'invoice_id' => $data->invoice->id,
//        'amount' => $data->dueDateProfit,
//        'status_id' => Status::query()->whereTitle(Statuses::PENDING)->first()->id,
//        'due_date' => CalendarService::gregorianDate($data->dueDate['due_date']),
//    ]);
//}
//
//
//public function update(Model $model, array|object $data): bool
//{
//    return $this->model->update([
//        'payment_date' => CalendarService::gregorianDate($data->payment_date),
//        'description' => $data->description,
//        'status_id' => $data->status_id,
//    ]);
//}
//
//public function geDueDatesOfProject($project_id): Collection
//{
//    return Installment::query()->whereHas('invoice', function ($q) use ($project_id) {
//        $q->whereHas('transaction', function ($q) use ($project_id) {
//            $q->whereHas('order', function ($q) use ($project_id) {
//                $q->whereHas('orderable', function ($query) use ($project_id) {
//                    $query->where('id', $project_id);
//                });
//            });
//        });
//    })->groupBy('due_date')->get('due_date');
//}
//
//public function getInstallmentsOfUser($user)
//{
//    return $this->model
//        ->whereUserId($user->id)
//        ->latest()
//        ->paginate($this->paginate);
//}
//
//public function getSumInstallmentsOfUser($user):int
//{
//    return $this->model
//        ->whereUserId($user->id)
//        ->sum('amount');
//}
