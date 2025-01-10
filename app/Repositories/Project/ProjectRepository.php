<?php

namespace App\Repositories\Project;


use App\Entities\User;
use App\Enums\TransactionStatuses;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function getCountProjectOfUser(User $user)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->join('p.orders', 'o')
            ->join('o.transaction', 't')
            ->where('t.status = :status')
            ->andWhere('o.user = :userId')
            ->setParameter('status', 'paid')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();

    }
}



//public function getInvoicesOfProject($project)
//{
//    return Invoice::query()
//        ->with('transaction.order.user')
//        ->whereHas('transaction', function ($query) use ($project) {
//            $query->whereStatusTitle(Statuses::PAID)
//                ->whereHas('invoice')
//                ->whereProjectId($project->id);
//        })
//        ->latest()
//        ->paginate(20);
//}
//
//public function getInvestorsOfProject($project)
//{
//    return User::query()->whereHas('orders', function ($query) use ($project) {
//        $query->whereHas('transaction', function ($query) use ($project) {
//            $query->whereStatusTitle(Statuses::PAID)
//                ->whereHas('invoice')
//                ->whereProjectId($project->id);
//        });
//    })->paginate(20);
//}
//
//public function updateOrStore($data): Model
//{
//    return Project::query()->updateOrCreate([
//        'id' => $data['project_id'] ?? null,
//    ], [
//        'title' => $data['title'],
//        'slug' => $data['slug'],
//        'user_id' => $data['user_id'],
//        'city_id' => $data['city_id']
//    ]);
//}
//
//public function updateFarabourseCode($project, $data): Model
//{
//    return FarabourseProject::query()->updateOrCreate([
//        'project_id' => $project->id,
//    ], [
//        'trace_code' => $data['trace_code'],
//    ]);
//}
//
//public function getCountProjectOfUser($user): int
//{
//    return $this->model
//        ->whereOrderUserPaid($user->id)
//        ->count();
//}
//
//public function toggleParticipation($project): bool
//{
//    return $this->update($project, [
//        'participation_generated' => !$project->participation_generated
//    ]);
//}
//
//public function getMediaFiles($project, $type = null)
//{
//    return Media::query()
//        ->whereProject($project)
//        ->when($type, function ($query) use ($type) {
//            $query->whereType($type);
//        })
//        ->latest()
//        ->get();
//}
//
//
//public function getFinanceFiles($project)
//{
//    return Media::query()
//        ->whereIn('type',['assessmentFile','guaranteeFile'])
//        ->whereProject($project)
//        ->latest()
//        ->get();
//}
