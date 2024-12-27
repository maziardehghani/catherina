<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use App\Repositories\Repository;

class SliderRepository extends Repository
{
    public function __construct()
    {
        $this->model = Slider::query();
        $this->paginate = 20;
    }
}
