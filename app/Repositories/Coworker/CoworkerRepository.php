<?php

namespace App\Repositories\Coworker;

use App\Models\Coworker;
use App\Repositories\Repository;



class CoworkerRepository extends Repository
{
    public function __construct()
    {
        $this->model = Coworker::query();
        $this->paginate = 20;
    }
}
