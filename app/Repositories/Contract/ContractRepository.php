<?php

namespace App\Repositories\Contract;

use App\Models\Contract;
use App\Repositories\Repository;

class ContractRepository extends Repository
{
    public function __construct()
    {
        $this->model = Contract::query();
        $this->paginate = 20;
    }
}
