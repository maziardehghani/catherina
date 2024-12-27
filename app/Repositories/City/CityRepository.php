<?php

namespace App\Repositories\City;

use App\Models\City;
use App\Repositories\Repository;

class CityRepository extends Repository
{
    public function __construct()
    {
        $this->model = City::query();
        $this->paginate = 20;
    }
}
