<?php

namespace App\Repositories\Project;

use App\Enums\Statuses;
use App\Models\FarabourseProject;
use App\Models\Invoice;
use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use App\Repositories\Repository;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

class ProjectRepository extends EntityRepository
{

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
