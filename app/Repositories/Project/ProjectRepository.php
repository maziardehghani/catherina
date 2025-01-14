<?php

namespace App\Repositories\Project;


use App\Entities\Project;
use App\Entities\Status;
use App\Entities\User;
use App\Enums\Statuses;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProjectRepository extends EntityRepository
{
    private $limit = 20;

    public function paginate($page = 1)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $this->limit)
            ->setMaxResults($this->limit);

        $paginator = new Paginator($queryBuilder->getQuery(), true);


        return [
            'data' => iterator_to_array($paginator),
            'current_page' => $page,
            'per_page' => $this->limit,
            'total' => $paginator->count(),
        ];
    }

    public function getCountProjectOfUser(User $user)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->join('p.orders', 'o')
            ->join('o.transaction', 't')
            ->where('t.status = :status')
            ->andWhere('o.user = :userId')
            ->setParameter('status', $this->getStatusByTitle(Statuses::PAID)->getId())
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function getStatusByTitle(Statuses $title)
    {
        return resolve(EntityManagerInterface::class)->createQueryBuilder()
            ->select('s')
            ->from(Status::class, 's')
            ->where('s.title = :status')
            ->andWhere('s.model = :model')
            ->setParameter('status', $title)
            ->setParameter('model', 'App\Entities\Transaction')
            ->getQuery()
            ->getSingleResult();
    }

    public function store($data)
    {
        $project = new Project();

        $project->setTitle($data['title']);
        $project->setSlug($data['slug']);
        $project->setUser($data['user_id']);
        $project->setCity($data['city_id']);
        $project->setStatus($data['status_id']);

        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();
        return $project;


    }


    public function updateStatus(Project $project, $data)
    {
        $project->setStatus($data['status_id']);
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();
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
