<?php

namespace App\Repositories\Team;

use App\Models\Coworker;
use App\Models\Team;
use App\Repositories\Repository;



class TeamRepository extends Repository
{
    public function __construct()
    {
        $this->model = Team::query();
        $this->paginate = 20;
    }
}
