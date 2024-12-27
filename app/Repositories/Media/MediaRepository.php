<?php

namespace App\Repositories\Media;

use App\Models\Coworker;
use App\Models\Media;
use App\Repositories\Repository;



class MediaRepository extends Repository
{
    public function __construct()
    {
        $this->model = Media::query();
        $this->paginate = 20;
    }
}
