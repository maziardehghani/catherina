<?php

namespace App\Repositories\ProjectsUserExperts;

use App\Models\ProjectUserExpert;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;

class ProjectUserExpertsRepository extends Repository
{
    public function __construct()
    {
        $this->model = ProjectUserExpert::query();
        $this->paginate = 20;
    }

    public function store(array|object $data): ProjectUserExpert
    {
        return ProjectUserExpert::query()->updateOrCreate([
            'project_id' => $data['project_id'],
        ],[
            'user_id' => $data['user_id'],
            'project_id' => $data['project_id'],
        ]);
    }

    public function whereProject($project): Collection
    {
        return $this->model->where('project_id', $project->id)->get();
    }
}
